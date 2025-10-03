# Complete Railway Deployment Guide for PokéStop

## 🚂 Step-by-Step Railway Deployment

### Phase 1: Set Up Railway Project

#### Step 1: Create Railway Account & New Project
1. Go to [railway.app](https://railway.app)
2. Sign in with your GitHub account
3. Click **"New Project"**
4. Select **"Deploy from GitHub repo"**
5. Choose your **`pokestop`** repository
6. Click **"Deploy Now"**

Railway will automatically detect it's a Laravel project and start deploying.

---

### Phase 2: Add Database Services

#### Step 2: Add MySQL Database
1. In your Railway project dashboard, click **"+ New"**
2. Select **"Database"** → **"Add MySQL"**
3. Railway will create a MySQL database and generate connection variables

**Important:** Note these environment variables (they're auto-generated):
- `MYSQL_HOST`
- `MYSQL_PORT`
- `MYSQL_DATABASE`
- `MYSQL_USER`
- `MYSQL_PASSWORD`
- `MYSQL_URL` (full connection string)

#### Step 3: Add MongoDB Database
1. Click **"+ New"** again
2. Select **"Database"** → **"Add MongoDB"**
3. Railway will create a MongoDB instance

**Important:** Note the MongoDB connection string:
- `MONGO_URL` or `MONGODB_URI`

---

### Phase 3: Configure Environment Variables

#### Step 4: Set Up Application Variables
Click on your **app service** (pokestop) → **Variables** tab → Add these:

```env
# Application Settings
APP_NAME=PokéStop
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.up.railway.app

# Generate this in Step 6
APP_KEY=

# MySQL Database (use Railway's provided variables)
DB_CONNECTION=mysql
DB_HOST=${MYSQL_HOST}
DB_PORT=${MYSQL_PORT}
DB_DATABASE=${MYSQL_DATABASE}
DB_USERNAME=${MYSQL_USER}
DB_PASSWORD=${MYSQL_PASSWORD}

# MongoDB (for Pokemon cache)
MONGODB_URI=${MONGO_URL}

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Mail (optional - set to 'log' for now)
MAIL_MAILER=log

# Other Settings
LOG_CHANNEL=stack
LOG_LEVEL=error
BROADCAST_DRIVER=log
FILESYSTEM_DISK=public
```

**💡 Tip:** Railway automatically provides `${MYSQL_HOST}`, `${MYSQL_PORT}`, etc. You can reference them directly!

---

### Phase 4: Configure Build & Deploy Settings

#### Step 5: Set Build Command
Go to **Settings** → **Deploy** section:

**Build Command:**
```bash
composer install --optimize-autoloader --no-dev && npm ci && npm run build && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

**OR** if you prefer shorter (Railway auto-detects):
```bash
composer install --no-dev && npm ci && npm run build
```

#### Step 6: Set Start Command
**Start Command:**
```bash
php artisan key:generate --force && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
```

**⚠️ Important:** Railway sets `$PORT` automatically. Don't hardcode it!

---

### Phase 5: Deploy & Initialize

#### Step 7: Trigger Deployment
1. Click **"Deploy"** or push a commit to GitHub
2. Watch the build logs in Railway dashboard
3. Wait for "Deployment successful" message

#### Step 8: Generate Application Key
After first deployment, go to your app service → **Variables** tab:

1. Railway should have auto-generated `APP_KEY` during first run
2. If not, open Railway's **Shell** (click the app service → ⋮ menu → Shell):
   ```bash
   php artisan key:generate --force
   ```
3. Copy the generated key to your Variables

#### Step 9: Run Database Migrations
In Railway Shell (⋮ menu → Shell):
```bash
php artisan migrate --force
```

Expected output:
```
Migration table created successfully.
Migrating: 0001_01_01_000000_create_users_table
Migrated:  0001_01_01_000000_create_users_table
...
```

#### Step 10: Seed Your Database
In Railway Shell:
```bash
php artisan db:seed --force
```

This will:
- Create admin user (admin@admin.com / password)
- Create test user (test@example.com / password)
- Add 20 Pokemon cards from pocketslabs.com
- Set up 4 categories

---

### Phase 6: Verify & Test

#### Step 11: Check Your Application
1. Click on your app URL: `https://your-app-name.up.railway.app`
2. Verify homepage loads
3. Check browse page shows Pokemon cards with images
4. Test login with:
   - **Admin:** admin@admin.com / password
   - **Test User:** test@example.com / password

#### Step 12: Test Database Connections

**Test MySQL:**
In Railway Shell:
```bash
php artisan tinker --execute="echo 'Products: ' . \App\Models\Product::count();"
```
Should show: `Products: 20`

**Test MongoDB:**
In Railway Shell:
```bash
php artisan tinker --execute="echo 'MongoDB: ' . (new \MongoDB\Client(env('MONGODB_URI')))->listDatabases() ? 'Connected' : 'Failed';"
```

---

## 🔧 Railway Configuration Files (Optional but Recommended)

### Option A: Use nixpacks.toml (Recommended)
Create `nixpacks.toml` in your project root:

```toml
[phases.setup]
nixPkgs = ["nodejs", "php82", "php82Packages.composer"]

[phases.install]
cmds = ["composer install --no-dev --optimize-autoloader", "npm ci"]

[phases.build]
cmds = ["npm run build", "php artisan config:cache", "php artisan route:cache", "php artisan view:cache"]

[start]
cmd = "php artisan key:generate --force && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT"
```

### Option B: Use railway.json
Create `railway.json` in your project root:

```json
{
  "$schema": "https://railway.app/railway.schema.json",
  "build": {
    "builder": "NIXPACKS"
  },
  "deploy": {
    "numReplicas": 1,
    "startCommand": "php artisan key:generate --force && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT",
    "restartPolicyType": "ON_FAILURE",
    "restartPolicyMaxRetries": 10
  }
}
```

---

## 📝 Post-Deployment Checklist

### ✅ Verify Everything Works:

- [ ] Homepage loads (/)
- [ ] Browse page shows 20 Pokemon cards with images (/browse)
- [ ] Product pages work (/products/{id})
- [ ] Login works (admin@admin.com / password)
- [ ] Admin dashboard accessible (/admin/dashboard)
- [ ] Cart functionality works
- [ ] Checkout creates orders
- [ ] Images load from pocketslabs.com CDN
- [ ] Pokemon API caching works (MongoDB)

---

## 🐛 Troubleshooting Common Issues

### Issue 1: "500 Server Error"
**Solution:**
1. Check Railway logs: Click app → **Deployments** → Click latest → **View Logs**
2. Enable debug temporarily: Set `APP_DEBUG=true` in Variables
3. Check `storage` folder has write permissions

### Issue 2: "Database Connection Failed"
**Solution:**
1. Verify MySQL service is running (should show "Active")
2. Check environment variables reference Railway's MySQL:
   ```
   DB_HOST=${MYSQL_HOST}
   DB_PORT=${MYSQL_PORT}
   ```
3. Run `php artisan config:clear` in Railway Shell

### Issue 3: "APP_KEY Not Set"
**Solution:**
Run in Railway Shell:
```bash
php artisan key:generate --force
```
Then redeploy.

### Issue 4: "MongoDB Connection Failed"
**Solution:**
1. Check MongoDB service is running
2. Verify `MONGODB_URI=${MONGO_URL}` in Variables
3. Test connection in Railway Shell:
   ```bash
   php artisan tinker --execute="dd(env('MONGODB_URI'));"
   ```

### Issue 5: "Images Not Loading"
**Solution:**
1. Check if image URLs are in database:
   ```bash
   php artisan tinker --execute="echo \App\Models\Product::first()->image_url;"
   ```
2. Verify images load externally (test pocketslabs.com URLs in browser)
3. Check CORS if needed

### Issue 6: "Migrations Already Run"
**Solution:**
Safe to ignore if database is already set up. To reset (⚠️ deletes data):
```bash
php artisan migrate:fresh --force --seed
```

---

## 🔄 Updating Your Deployed App

### For Code Changes:
1. Commit and push to GitHub:
   ```bash
   git add .
   git commit -m "Update code"
   git push origin main
   ```
2. Railway auto-deploys on push!

### For Database Changes:
1. Create new migration locally:
   ```bash
   php artisan make:migration add_new_field
   ```
2. Push to GitHub
3. Run in Railway Shell:
   ```bash
   php artisan migrate --force
   ```

### For Environment Variables:
1. Update in Railway Dashboard → Variables
2. Redeploy (Railway auto-redeploys on variable change)

---

## 📊 Monitoring Your App

### Check Application Logs:
Railway Dashboard → Your App → **Deployments** → **View Logs**

### Check Database Size:
Railway Dashboard → MySQL/MongoDB Service → **Metrics** tab

### Check Application Health:
Visit: `https://your-app.up.railway.app/health` (if you add a health route)

---

## 💰 Railway Pricing Notes

- **Starter Plan**: $5/month credit (plenty for development)
- **Pro Plan**: $20/month (recommended for production)
- Each service (App, MySQL, MongoDB) uses resources
- Monitor usage in Railway Dashboard

---

## 🎯 Quick Reference Commands

### Railway Shell Commands:
```bash
# Check app status
php artisan about

# View routes
php artisan route:list

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Check database
php artisan db:show

# Run specific seeder
php artisan db:seed --class=PokemonCardsSeeder --force

# Create admin user manually
php artisan tinker
# Then: User::create(['name'=>'Admin','email'=>'admin@admin.com','password'=>bcrypt('password'),'role'=>'admin']);
```

---

## 🚀 You're Ready!

Your PokéStop Pokemon card shop should now be live on Railway with:
- ✅ Laravel app running
- ✅ MySQL database connected
- ✅ MongoDB for Pokemon cache
- ✅ 20 Pokemon cards seeded
- ✅ Admin panel accessible
- ✅ Auto-deploys on GitHub push

**Your Live URL:** `https://your-app-name.up.railway.app`

Show it to your lecturer! 🎓

---

## 📞 Need Help?

- **Railway Docs:** https://docs.railway.app
- **Laravel Deployment:** https://laravel.com/docs/deployment
- **Check Logs:** Railway Dashboard → View Logs
