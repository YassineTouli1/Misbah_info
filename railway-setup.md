# Railway Deployment Setup for Snack App

## Step 1: Prepare Your Repository

1. **Push your code to GitHub** (if not already done)
2. **Create a new repository** on GitHub
3. **Push your code** to the repository

## Step 2: Set up Railway

1. **Go to** [railway.app](https://railway.app)
2. **Sign up** with your GitHub account
3. **Click "New Project"**
4. **Select "Deploy from GitHub repo"**
5. **Choose your snack app repository**

## Step 3: Add PostgreSQL Database

1. **In your Railway project dashboard**
2. **Click "New" → "Database" → "PostgreSQL"**
3. **Wait for database to be created**
4. **Copy the database connection details**

## Step 4: Configure Environment Variables

In Railway project settings, add these environment variables:

```
APP_NAME=Snack App
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-app-name.railway.app

DB_CONNECTION=pgsql
DB_HOST=your-postgres-host
DB_PORT=5432
DB_DATABASE=your-database-name
DB_USERNAME=your-username
DB_PASSWORD=your-password

FILESYSTEM_DISK=public
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database
```

## Step 5: Generate App Key

Run this command locally to generate APP_KEY:
```bash
php artisan key:generate --show
```

## Step 6: Deploy

1. **Railway will automatically deploy** when you push to GitHub
2. **Check the deployment logs** for any errors
3. **Your app will be available** at the provided Railway URL

## Step 7: Run Migrations

After deployment, run migrations:
1. **Go to Railway dashboard**
2. **Click on your service**
3. **Go to "Deployments" tab**
4. **Click "View Logs"**
5. **Run**: `php artisan migrate --force`

## Step 8: Set up File Storage

For image uploads, you can:
1. **Use Railway's built-in storage** (temporary)
2. **Set up AWS S3** for permanent storage
3. **Use Cloudinary** (free tier available)

## Troubleshooting

- **Check logs** in Railway dashboard
- **Verify environment variables** are set correctly
- **Ensure database connection** is working
- **Check file permissions** for storage directory
