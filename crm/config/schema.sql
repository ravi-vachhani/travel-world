-- =============================================================================
-- Travel World CRM - Supabase schema
-- Run this in the Supabase SQL editor (project: pxrtabaeqnghotaowytx).
--
-- Design notes:
--  * Every table uses a TEXT primary key `id` (CRM generates IDs like "TWxxxxxx")
--    and a `created_at` timestamptz, matching what the PHP client expects
--    (mapped to Appwrite-style $id / $createdAt in supabase-client.php).
--  * Columns are permissive (text / nullable) to mirror the schema-less
--    document model the CRM was built against.
-- =============================================================================

-- ── customers ───────────────────────────────────────────────────────────────
create table if not exists public.customers (
    id              text primary key,
    name            text,
    email           text,
    phone           text,
    alt_phone       text,
    dob             text,
    anniversary     text,
    address         text,
    city            text,
    state           text,
    country         text,
    passport_no     text,
    passport_expiry text,
    notes           text,
    enquiry_count   integer default 0,
    booking_count   integer default 0,
    lead_id         text,
    customer_id     text,
    created_at      timestamptz default now()
);

-- ── leads ────────────────────────────────────────────────────────────────────
create table if not exists public.leads (
    id            text primary key,
    lead_id       text,
    name          text,
    email         text,
    phone         text,
    source        text,
    service_type  text,
    destination   text,
    travel_date   text,
    adults        integer default 0,
    children      integer default 0,
    budget        text,
    notes         text,
    status        text default 'new',
    assigned_to   text,
    customer_id   text,
    created_at    timestamptz default now()
);

-- ── enquiries ─────────────────────────────────────────────────────────────────
create table if not exists public.enquiries (
    id             text primary key,
    enquiry_id     text,
    lead_id        text,
    customer_id    text,
    customer_name  text,
    customer_phone text,
    customer_email text,
    service_type   text,
    destination    text,
    travel_date    text,
    adults         integer default 0,
    children       integer default 0,
    budget         text,
    details        text,
    notes          text,
    status         text default 'new',
    assigned_to    text,
    created_at     timestamptz default now()
);

-- ── followups ─────────────────────────────────────────────────────────────────
create table if not exists public.followups (
    id            text primary key,
    enquiry_id    text,
    lead_id       text,
    customer_id   text,
    customer_name text,
    type          text,
    scheduled_at  text,
    notes         text,
    done          boolean default false,
    created_at    timestamptz default now()
);

-- ── quotations ────────────────────────────────────────────────────────────────
create table if not exists public.quotations (
    id             text primary key,
    quotation_id   text,
    enquiry_id     text,
    customer_name  text,
    customer_phone text,
    customer_email text,
    destination    text,
    travel_date    text,
    adults         integer default 0,
    children       integer default 0,
    items          text,
    subtotal       numeric default 0,
    discount       numeric default 0,
    tax            numeric default 0,
    total          numeric default 0,
    notes          text,
    terms          text,
    status         text default 'draft',
    version        integer default 1,
    valid_until    text,
    created_at     timestamptz default now()
);

-- ── bookings ──────────────────────────────────────────────────────────────────
create table if not exists public.bookings (
    id             text primary key,
    booking_id     text,
    enquiry_id     text,
    quotation_id   text,
    customer_id    text,
    customer_name  text,
    customer_phone text,
    customer_email text,
    destination    text,
    service_type   text,
    travel_date    text,
    return_date    text,
    adults         integer default 0,
    children       integer default 0,
    supplier       text,
    booking_ref    text,
    total_amount   numeric default 0,
    paid_amount    numeric default 0,
    notes          text,
    status         text default 'confirmed',
    created_at     timestamptz default now()
);

-- ── payments ──────────────────────────────────────────────────────────────────
create table if not exists public.payments (
    id            text primary key,
    booking_id    text,
    customer_id   text,
    customer_name text,
    amount        numeric default 0,
    payment_type  text,
    method        text,
    reference     text,
    paid_at       text,
    notes         text,
    created_at    timestamptz default now()
);

-- ── documents ─────────────────────────────────────────────────────────────────
create table if not exists public.documents (
    id            text primary key,
    booking_id    text,
    enquiry_id    text,
    customer_id   text,
    customer_name text,
    doc_type      text,
    filename      text,
    file_url      text,
    notes         text,
    status        text default 'uploaded',
    created_at    timestamptz default now()
);

-- ── feedback ──────────────────────────────────────────────────────────────────
create table if not exists public.feedback (
    id            text primary key,
    booking_id    text,
    customer_name text,
    rating        integer,
    comments      text,
    created_at    timestamptz default now()
);

-- Helpful indexes for the lookups the CRM performs most often.
create index if not exists idx_enquiries_customer_id on public.enquiries (customer_id);
create index if not exists idx_bookings_customer_id   on public.bookings (customer_id);
create index if not exists idx_payments_booking_id    on public.payments (booking_id);
create index if not exists idx_documents_booking_id   on public.documents (booking_id);
create index if not exists idx_followups_enquiry_id   on public.followups (enquiry_id);
create index if not exists idx_quotations_enquiry_id  on public.quotations (enquiry_id);

-- =============================================================================
-- Storage bucket for CRM documents.
-- The PHP client uploads with the service-role key, so RLS is bypassed; a public
-- bucket lets the generated file_url be viewed directly.
-- Create it in the Supabase dashboard (Storage → New bucket, name: crm-documents,
-- Public = on), or run:
--   insert into storage.buckets (id, name, public)
--   values ('crm-documents', 'crm-documents', true)
--   on conflict (id) do nothing;
-- =============================================================================

-- =============================================================================
-- Reload the PostgREST schema cache so the REST API sees the new tables
-- immediately. Without this you may briefly get:
--   "Could not find the table 'public.<name>' in the schema cache"
-- =============================================================================
notify pgrst, 'reload schema';
