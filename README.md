-- Insert a tenant into the 'tenants' table
INSERT INTO tenants (id, data, created_at, updated_at)
VALUES ('tenant_3', '{}', NOW(), NOW());

-- Insert a domain record into the 'domains' table for 'tenant_1'
INSERT INTO domains (domain, tenant_id, created_at, updated_at)
VALUES ('branch1.localhost', 'tenant_3', NOW(), NOW());


-- Insert a tenant into the 'tenants' table
INSERT INTO tenants (id, data, created_at, updated_at)
VALUES ('tenant_2', '{}', NOW(), NOW());

-- Insert a domain record into the 'domains' table for 'tenant_1'
INSERT INTO domains (domain, tenant_id, created_at, updated_at)
VALUES ('main.localhost', 'tenant_2', NOW(), NOW());


-- Insert a tenant into the 'tenants' table
INSERT INTO tenants (id, data, created_at, updated_at)
VALUES ('tenant_1', '{}', NOW(), NOW());

-- Insert a domain record into the 'domains' table for 'tenant_1'
INSERT INTO domains (domain, tenant_id, created_at, updated_at)
VALUES ('localhost', 'tenant_1', NOW(), NOW());
