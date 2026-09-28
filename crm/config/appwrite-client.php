<?php
/**
 * Appwrite PHP SDK Client
 * Lightweight HTTP wrapper (no Composer needed on Vercel)
 */

class AppwriteClient {
    private string $endpoint;
    private string $projectId;
    private string $apiKey;
    private string $databaseId;

    public function __construct() {
        $this->endpoint   = APPWRITE_ENDPOINT;
        $this->projectId  = APPWRITE_PROJECT_ID;
        $this->apiKey     = APPWRITE_API_KEY;
        $this->databaseId = APPWRITE_DATABASE_ID;
    }

    private function request(string $method, string $path, array $body = [], string $rawQuery = ''): array {
        $url = rtrim($this->endpoint, '/') . $path;
        if ($rawQuery !== '') {
            $url .= '?' . $rawQuery;
        }

        $headers = [
            'Content-Type: application/json',
            'X-Appwrite-Project: ' . $this->projectId,
            'X-Appwrite-Key: ' . $this->apiKey,
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        } elseif ($method === 'PATCH') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        } elseif ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErr  = curl_error($ch);
        curl_close($ch);

        if ($curlErr) {
            error_log("Appwrite cURL error: " . $curlErr);
            return ['error' => $curlErr];
        }

        $data = json_decode($response, true) ?? [];
        if ($httpCode >= 400) {
            error_log("Appwrite error [{$httpCode}] {$path}: " . $response);
        }
        return $data;
    }

    // ── Documents ──────────────────────────────────────────────────────────

    public function listDocuments(string $collection, array $queries = []): array {
        // Appwrite REST API requires repeated queries[] params
        $parts = [];
        foreach ($queries as $q) {
            $parts[] = 'queries[]=' . urlencode($q);
        }
        $rawQuery = implode('&', $parts);
        return $this->request('GET', "/databases/{$this->databaseId}/collections/{$collection}/documents", [], $rawQuery);
    }

    public function getDocument(string $collection, string $documentId): array {
        return $this->request('GET', "/databases/{$this->databaseId}/collections/{$collection}/documents/{$documentId}");
    }

    public function createDocument(string $collection, array $data, string $documentId = 'unique()'): array {
        return $this->request('POST', "/databases/{$this->databaseId}/collections/{$collection}/documents", [
            'documentId' => $documentId,
            'data'       => $data,
        ]);
    }

    public function updateDocument(string $collection, string $documentId, array $data): array {
        return $this->request('PATCH', "/databases/{$this->databaseId}/collections/{$collection}/documents/{$documentId}", [
            'data' => $data,
        ]);
    }

    public function deleteDocument(string $collection, string $documentId): array {
        return $this->request('DELETE', "/databases/{$this->databaseId}/collections/{$collection}/documents/{$documentId}");
    }

    // ── Storage ────────────────────────────────────────────────────────────

    public function getFileViewUrl(string $fileId): string {
        return "{$this->endpoint}/storage/buckets/" . APPWRITE_BUCKET_ID . "/files/{$fileId}/view"
             . "?project={$this->projectId}";
    }

    // ── Helpers ────────────────────────────────────────────────────────────

    public function generateId(): string {
        return 'TW' . strtoupper(substr(uniqid(), -6));
    }

    /**
     * Debug: returns last raw Appwrite error for display
     */
    public function testConnection(): array {
        return $this->request('GET', "/databases/{$this->databaseId}/collections");
    }
}

// Global singleton
function appwrite(): AppwriteClient {
    static $instance = null;
    if ($instance === null) {
        $instance = new AppwriteClient();
    }
    return $instance;
}