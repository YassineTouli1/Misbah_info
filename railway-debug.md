# Railway Deployment Debug Guide

## Common Healthcheck Issues and Solutions

### 1. App Not Starting
**Symptoms:** Healthcheck fails immediately
**Solutions:**
- Check if APP_KEY is set
- Verify database connection
- Check for missing dependencies

### 2. Port Issues
**Symptoms:** Connection refused
**Solutions:**
- Ensure app binds to 0.0.0.0:$PORT
- Check Railway environment variables

### 3. Database Connection Issues
**Symptoms:** App starts but healthcheck fails
**Solutions:**
- Verify PostgreSQL credentials
- Check database exists
- Run migrations

## Debug Steps

### Step 1: Check Railway Logs
1. Go to Railway dashboard
2. Click on your service
3. Go to "Deployments" tab
4. Click "View Logs"
5. Look for error messages

### Step 2: Test Health Check Locally
```bash
# Start your app locally
php artisan serve

# Test health check
curl http://localhost:8000/health
```

### Step 3: Check Environment Variables
Make sure these are set in Railway:
- APP_KEY
- DB_CONNECTION=pgsql
- DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD

### Step 4: Manual Database Setup
If database is the issue:
1. Connect to Railway PostgreSQL
2. Create database manually
3. Run migrations manually

## Quick Fixes

### Fix 1: Simple Health Check
Use `/ping` endpoint instead of `/health`:
- Change healthcheckPath to `/ping` in Railway settings

### Fix 2: Disable Health Check Temporarily
- Remove healthcheckPath from Railway settings
- Deploy without health check
- Debug the app manually

### Fix 3: Use Root Path
- Change healthcheckPath to `/` in Railway settings
- Make sure root route returns 200 status
