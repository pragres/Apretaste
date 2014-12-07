ALTER TABLE email_outbox
  ADD COLUMN locked boolean NOT NULL DEFAULT false;
