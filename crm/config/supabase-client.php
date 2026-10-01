<?php
/**
 * Supabase Client
 *
 * Lightweight HTTP wrapper over Supabase PostgREST + Storage (no Composer /
 * SDK required). It intentionally exposes the SAME interface the CRM used for
 * Appwrite (listDocuments / getDocument / createDocument / updateDocument /
 * deleteDocument) and returns documents using Appwrite-style keys ($id,
 * $createdAt) so the rest of the CRM keeps working unchanged.
 *
 * Postgres tables are expected to have:
 *   id          text primary key   (mapped to $id)
 *   created_at  timestamptz        (mapped to $createdAt)
 */

class SupabaseClient {
    private string $restUrl;
    private string $url;
    private string $serviceKey;
    private string $bucket;

    /** Human-readable description of the most recent failed request, if any. */
    private string $lastError = '';

    public function __construct() {
        $this->restUrl    = SUPABASE_REST_URL;
        $this->url        = SUPABASE_URL;
        $this->serviceKey = SUPABASE_SERVICE_KEY;
        $this->bucket     = SUPABASE_BUCKET;
    }

    /** Returns the last error message captured by a request (empty if none). */
    public function lastError(): string {
        return $this->lastError;
    }

    // ── Low level REST request ───────────────────────────────────────────────

    /**
     * @return array{status:int, body:mixed, headers:array}
     */
    private function request(string $method, string $path, $body = null, array $extraHeaders = []): array {
        $this->lastError = '';
        $url = rtrim($this->restUrl, '/') . $path;

        $headers = array_merge([
            'apikey: ' . $this->serviceKey,
            'Authorization: Bearer ' . $this->serviceKey,
            'Content-Type: application/json',
        ], $extraHeaders);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        if ($body !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        }

        $raw      = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $curlErr  = curl_error($ch);
        curl_close($ch);

        if ($curlErr) {
            $this->lastError = 'Connection error: ' . $curlErr;
            error_log("Supabase cURL error: " . $curlErr);
            return ['status' => 0, 'body' => ['error' => $curlErr], 'headers' => []];
        }

        $rawHeaders = substr($raw, 0, $headerSize);
        $rawBody    = substr($raw, $headerSize);
        $headers    = $this->parseHeaders($rawHeaders);

        $data = $rawBody === '' ? [] : (json_decode($rawBody, true));

        if ($httpCode >= 400) {
            // PostgREST errors look like {"code":..,"message":..,"details":..,"hint":..}
            $msg = '';
            if (is_array($data)) {
                $msg = trim(($data['message'] ?? '') . ' ' . ($data['details'] ?? '') . ' ' . ($data['hint'] ?? ''));
            }
            $this->lastError = "[{$httpCode}] " . ($msg !== '' ? $msg : $rawBody);
            error_log("Supabase error {$this->lastError} on {$method} {$path}");
        }

        return ['status' => $httpCode, 'body' => $data, 'headers' => $headers];
    }

    private function parseHeaders(string $raw): array {
        $out = [];
        foreach (explode("\r\n", $raw) as $line) {
            if (strpos($line, ':') !== false) {
                [$k, $v] = explode(':', $line, 2);
                $out[strtolower(trim($k))] = trim($v);
            }
        }
        return $out;
    }

    // ── Appwrite-style query translation ─────────────────────────────────────

    /**
     * Translate the Appwrite-style query strings used across the CRM into a
     * PostgREST query string.
     *
     * Supported:
     *   equal("field","value")        -> field=eq.value
     *   notEqual("field","value")     -> field=neq.value
     *   greaterThan("field","v")      -> field=gt.v
     *   greaterThanEqual("field","v") -> field=gte.v
     *   lessThan("field","v")         -> field=lt.v
     *   lessThanEqual("field","v")    -> field=lte.v
     *   search("field","value")       -> field=ilike.*value*
     *   orderAsc("field")             -> order=field.asc
     *   orderDesc("field")            -> order=field.desc
     *   limit(n)                      -> limit=n
     *   offset(n)                     -> offset=n
     *
     * Also accepts boolean literals (true/false) and the special Appwrite
     * fields "$id"/"$createdAt" which map to id/created_at.
     */
    private function buildQuery(array $queries): string {
        $params  = [];
        $orders  = [];

        foreach ($queries as $q) {
            $q = trim($q);
            if (!preg_match('/^([a-zA-Z]+)\((.*)\)$/s', $q, $m)) {
                continue;
            }
            $op   = $m[1];
            $args = $this->parseArgs($m[2]);

            switch ($op) {
                case 'equal':
                case 'notEqual':
                case 'greaterThan':
                case 'greaterThanEqual':
                case 'lessThan':
                case 'lessThanEqual':
                case 'search':
                    $field = $this->mapField($args[0] ?? '');
                    $value = $args[1] ?? '';
                    $opMap = [
                        'equal'            => 'eq',
                        'notEqual'         => 'neq',
                        'greaterThan'      => 'gt',
                        'greaterThanEqual' => 'gte',
                        'lessThan'         => 'lt',
                        'lessThanEqual'    => 'lte',
                    ];
                    if ($op === 'search') {
                        $params[] = rawurlencode($field) . '=ilike.' . rawurlencode('*' . $value . '*');
                    } else {
                        $params[] = rawurlencode($field) . '=' . $opMap[$op] . '.' . rawurlencode($value);
                    }
                    break;

                case 'orderAsc':
                    $orders[] = $this->mapField($args[0] ?? '') . '.asc';
                    break;
                case 'orderDesc':
                    $orders[] = $this->mapField($args[0] ?? '') . '.desc';
                    break;

                case 'limit':
                    $params[] = 'limit=' . (int)($args[0] ?? 25);
                    break;
                case 'offset':
                    $params[] = 'offset=' . (int)($args[0] ?? 0);
                    break;
            }
        }

        if ($orders) {
            $params[] = 'order=' . rawurlencode(implode(',', $orders));
        }

        return implode('&', $params);
    }

    /**
     * Parse the comma separated argument list of an Appwrite query helper.
     * Strips surrounding single/double quotes; leaves bare literals (numbers,
     * true/false) untouched.
     */
    private function parseArgs(string $argStr): array {
        $args = [];
        // Split on commas that are not inside quotes
        $parts = preg_split('/,(?=(?:[^"\']*(?:"[^"]*"|\'[^\']*\'))*[^"\']*$)/', $argStr);
        foreach ($parts as $p) {
            $p = trim($p);
            if ($p === '') continue;
            if ((str_starts_with($p, '"') && str_ends_with($p, '"')) ||
                (str_starts_with($p, "'") && str_ends_with($p, "'"))) {
                $args[] = substr($p, 1, -1);
            } else {
                $args[] = $p; // numeric / boolean literal
            }
        }
        return $args;
    }

    /** Map Appwrite special fields to Postgres columns. */
    private function mapField(string $field): string {
        if ($field === '$id')        return 'id';
        if ($field === '$createdAt') return 'created_at';
        if ($field === '$updatedAt') return 'updated_at';
        return $field;
    }

    /** Convert a Postgres row into an Appwrite-style document. */
    private function toDocument($row): array {
        if (!is_array($row) || !$row) return [];
        $doc = $row;
        $doc['$id']        = $row['id'] ?? null;
        $doc['$createdAt'] = $row['created_at'] ?? null;
        $doc['$updatedAt'] = $row['updated_at'] ?? ($row['created_at'] ?? null);
        return $doc;
    }

    /**
     * Normalise a response body into a list of row arrays.
     *
     * PostgREST returns a JSON array of rows on success, but a JSON object
     * (e.g. {"code":"PGRST205","message":...}) on error. Only a true list of
     * row objects should be iterated; anything else is logged and treated as
     * an empty result so the CRM degrades gracefully instead of fataling.
     */
    private function rowsFrom($body): array {
        if (!is_array($body)) {
            return [];
        }
        // Associative array => PostgREST error object, not a row list.
        if (array_keys($body) !== range(0, count($body) - 1)) {
            if (isset($body['message']) || isset($body['code'])) {
                error_log('Supabase response error: ' . json_encode($body));
            }
            return [];
        }
        // Keep only genuine row objects.
        return array_values(array_filter($body, 'is_array'));
    }

    // ── Documents (Appwrite-compatible API) ──────────────────────────────────

    public function listDocuments(string $table, array $queries = []): array {
        $qs   = $this->buildQuery($queries);
        $path = "/{$table}?select=*" . ($qs ? '&' . $qs : '');

        $res = $this->request('GET', $path, null, [
            'Prefer: count=exact',
        ]);

        $rows = $this->rowsFrom($res['body']);
        $docs = array_map([$this, 'toDocument'], $rows);

        // Extract total from Content-Range header: "0-24/137"
        $total = count($docs);
        $range = $res['headers']['content-range'] ?? '';
        if ($range && strpos($range, '/') !== false) {
            $after = substr($range, strpos($range, '/') + 1);
            if (is_numeric($after)) {
                $total = (int)$after;
            }
        }

        return [
            'documents' => $docs,
            'total'     => $total,
        ];
    }

    public function getDocument(string $table, string $documentId): array {
        $path = "/{$table}?select=*&id=eq." . rawurlencode($documentId) . "&limit=1";
        $res  = $this->request('GET', $path);
        $rows = $this->rowsFrom($res['body']);
        return $this->toDocument($rows[0] ?? null);
    }

    public function createDocument(string $table, array $data, string $documentId = ''): array {
        // Appwrite system fields are not real columns; strip them.
        unset($data['$id'], $data['$createdAt'], $data['$updatedAt']);

        if (!isset($data['id']) || $data['id'] === '') {
            $data['id'] = ($documentId !== '' && $documentId !== 'unique()')
                ? $documentId
                : $this->generateId();
        }

        $res = $this->request('POST', "/{$table}", $data, [
            'Prefer: return=representation',
        ]);

        // PostgREST returns an array of the inserted rows.
        $rows = $this->rowsFrom($res['body']);
        return $this->toDocument($rows[0] ?? null);
    }

    public function updateDocument(string $table, string $documentId, array $data): array {
        unset($data['$id'], $data['$createdAt'], $data['$updatedAt'], $data['id']);

        $path = "/{$table}?id=eq." . rawurlencode($documentId);
        $res  = $this->request('PATCH', $path, $data, [
            'Prefer: return=representation',
        ]);

        $rows = $this->rowsFrom($res['body']);
        return $this->toDocument($rows[0] ?? null);
    }

    public function deleteDocument(string $table, string $documentId): array {
        $path = "/{$table}?id=eq." . rawurlencode($documentId);
        $res  = $this->request('DELETE', $path);
        return ['status' => $res['status']];
    }

    // ── Storage ──────────────────────────────────────────────────────────────

    /**
     * Upload a file to the Supabase Storage bucket.
     * Returns the public URL on success, or '' on failure.
     */
    public function uploadFile(string $tmpPath, string $filename, string $contentType = 'application/octet-stream'): string {
        // Unique object path inside the bucket
        $objectPath = date('Y/m/') . $this->generateId() . '-' . rawurlencode($filename);
        $endpoint   = rtrim($this->url, '/') . '/storage/v1/object/' . $this->bucket . '/' . $objectPath;

        $fh = fopen($tmpPath, 'rb');
        if (!$fh) return '';
        $size = filesize($tmpPath);

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PUT, true);
        curl_setopt($ch, CURLOPT_INFILE, $fh);
        curl_setopt($ch, CURLOPT_INFILESIZE, $size);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'apikey: ' . $this->serviceKey,
            'Authorization: Bearer ' . $this->serviceKey,
            'Content-Type: ' . $contentType,
            'x-upsert: true',
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErr  = curl_error($ch);
        curl_close($ch);
        fclose($fh);

        if ($curlErr || $httpCode >= 400) {
            error_log("Supabase storage upload error [{$httpCode}]: " . ($curlErr ?: $response));
            return '';
        }

        return $this->getFileViewUrl($objectPath);
    }

    /** Public URL for an object in the bucket. */
    public function getFileViewUrl(string $objectPath): string {
        return rtrim($this->url, '/') . '/storage/v1/object/public/' . $this->bucket . '/' . ltrim($objectPath, '/');
    }

    // ── Helpers ────────────────────────────────────────────────────────────

    public function generateId(): string {
        return 'TW' . strtoupper(substr(uniqid(), -6)) . strtoupper(substr(bin2hex(random_bytes(2)), 0, 3));
    }

    /** Debug: simple connectivity check against a known table. */
    public function testConnection(): array {
        $res = $this->request('GET', '/' . COL_LEADS . '?select=id&limit=1', null, ['Prefer: count=exact']);
        return [
            'status'  => $res['status'],
            'body'    => $res['body'],
            'headers' => $res['headers'],
        ];
    }
}

// Global singleton. Keeps the historical appwrite() name so existing CRM pages
// that call appwrite() continue to work, now backed by Supabase.
function supabase(): SupabaseClient {
    static $instance = null;
    if ($instance === null) {
        $instance = new SupabaseClient();
    }
    return $instance;
}

if (!function_exists('appwrite')) {
    /** Backwards-compatible alias used throughout the CRM. */
    function appwrite(): SupabaseClient {
        return supabase();
    }
}
