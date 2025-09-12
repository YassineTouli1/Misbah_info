-- Migration script to convert SQLite to PostgreSQL
-- Run this after setting up PostgreSQL database

-- First, create the database tables (run php artisan migrate first)
-- Then use this script to migrate data from SQLite to PostgreSQL

-- Example data migration (adjust based on your actual data):
-- INSERT INTO users (name, email, email_verified_at, password, created_at, updated_at)
-- SELECT name, email, email_verified_at, password, created_at, updated_at 
-- FROM sqlite_master WHERE type='table' AND name='users';

-- Note: You'll need to export your SQLite data and import it manually
-- or use a tool like pgloader for automatic migration
