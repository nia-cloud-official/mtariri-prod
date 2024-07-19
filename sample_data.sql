-- Insert sample policy
INSERT INTO policies (user_id, policy_number, start_date, end_date, details) VALUES
(1, 'POL12345', '2024-01-01', '2025-01-01', 'Details about the policy.');

-- Insert sample claim
INSERT INTO claims (user_id, policy_id, claim_date, status, details) VALUES
(1, 1, '2024-06-01', 'Pending', 'Details about the claim.');
