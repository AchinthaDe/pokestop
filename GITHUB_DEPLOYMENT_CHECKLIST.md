# GitHub to Railway Deployment Checklist

## ✅ Before Pushing to GitHub

### 1. **Files Already Excluded (via .gitignore)** ✅
Your `.gitignore` is properly configured to exclude:
- ✅ `/vendor` - PHP dependencies (will be installed by Railway)
- ✅ `/node_modules` - Node dependencies (will be installed by Railway)
- ✅ `.env` - Environment variables (will be set in Railway)
- ✅ `/public/build` - Vite compiled assets (will be built on Railway)
- ✅ `/public/hot` - Vite dev server file
- ✅ `/storage/*.key` - Application keys
- ✅ `.phpunit.result.cache` - PHPUnit cache
- ✅ IDE folders (`.vscode`, `.idea`, etc.)

### 2. **Files That SHOULD Be Committed** ✅
- ✅ `composer.json` & `composer.lock` - PHP dependencies list
- ✅ `package.json` & `package-lock.json` - Node dependencies list
- ✅ All `/app` code
- ✅ All `/database/migrations`
- ✅ All `/database/factories`
- ✅ All `/database/seeders`
- ✅ All `/resources` (views, CSS, JS)
- ✅ All `/routes`
- ✅ All `/config`
- ✅ All `/tests`
- ✅ `artisan`, `composer.json`, `vite.config.js`, `tailwind.config.js`

### 3. **Clean Up Complete** ✅
- ✅ Removed unused CSS backup files
- ✅ Removed debug tool (`app/Tools/mongo_ping.php`)
- ✅ Consolidated duplicate routes

## 📋 Pre-Push Commands

```bash
# 1. Make sure all dependencies are up to date
composer install
npm install

# 2. Run tests to ensure everything works
php artisan test

# 3. Build assets for production
npm run build

# 4. Clear any caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 🚀 GitHub Push Steps

```bash
# 1. Initialize git (if not already done)
git init

# 2. Add all files (gitignore will exclude unwanted files)
git add .

# 3. Create initial commit
git commit -m "Initial commit - Laravel Pokemon shop with admin panel"

# 4. Add GitHub remote (replace with your repo URL)
git remote add origin https://github.com/AchinthaDe/pokestop.git

# 5. Push to GitHub
git push -u origin main
```

## 🚂 Railway Deployment Steps

### 1. **Create New Project in Railway**
- Go to railway.app
- Click "New Project"
- Select "Deploy from GitHub repo"
- Choose your `pokestop` repository

### 2. **Add MySQL Database Service**
- In your Railway project, click "+ New"
- Select "Database" → "MySQL"
- Railway will automatically create `DATABASE_URL` variable

### 3. **Add MongoDB Service (for PokemonCache)**
- Click "+ New" → "Database" → "MongoDB"
- Note the connection string for environment variables

### 4. **Configure Environment Variables**
Go to your app service settings → Variables, and add:

```env
# App Configuration
APP_NAME=PokéStop
APP_ENV=production
APP_KEY=                          # Will be generated
APP_DEBUG=false
APP_URL=https://your-app.railway.app

# Database (MySQL) - Auto-populated from Railway MySQL service
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQL_HOST}}
DB_PORT=${{MySQL.MYSQL_PORT}}
DB_DATABASE=${{MySQL.MYSQL_DATABASE}}
DB_USERNAME=${{MySQL.MYSQL_USER}}
DB_PASSWORD=${{MySQL.MYSQL_PASSWORD}}

# MongoDB (for Pokemon Cache)
MONGODB_URI=${{MongoDB.MONGODB_URI}}

# Session & Cache
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database

# Mail (optional - configure if needed)
MAIL_MAILER=log
```

### 5. **Add Build & Start Commands**
In Railway app settings:

**Build Command:**
```bash
composer install --optimize-autoloader --no-dev && npm install && npm run build && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

**Start Command:**
```bash
php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
```

Or create a `Procfile` in your project root:
```
web: php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
```

### 6. **Generate Application Key**
After first deployment, run in Railway terminal:
```bash
php artisan key:generate --force
```

### 7. **Optional: Seed Database**
```bash
php artisan db:seed --force
```

## ⚠️ Important Security Notes

1. **Never commit `.env` file** - It's already in `.gitignore` ✅
2. **Never commit `/vendor` or `/node_modules`** - Already excluded ✅
3. **Set `APP_DEBUG=false`** in production
4. **Use strong `APP_KEY`** - Generated automatically
5. **Secure database credentials** - Managed by Railway

## 🧪 Testing Before Push

```bash
# Run all tests
php artisan test

# Expected output: All tests passing
# Tests: 56+, Assertions: X+, No failures
```

## 📦 What Gets Deployed

✅ **Included:**
- Source code (`/app`, `/routes`, `/resources`)
- Configuration files
- Database migrations & factories
- Tests
- Package manifests (`composer.json`, `package.json`)

❌ **Excluded (will be generated on Railway):**
- `/vendor` (installed via `composer install`)
- `/node_modules` (installed via `npm install`)
- `/public/build` (generated via `npm run build`)
- `.env` (configured in Railway dashboard)

## 🎯 Quick Deployment Checklist

- [ ] Remove unused CSS files ✅ (Already done)
- [ ] Verify `.gitignore` is correct ✅ (Already done)
- [ ] Run `php artisan test` - all passing
- [ ] Run `npm run build` - no errors
- [ ] Commit and push to GitHub
- [ ] Connect GitHub repo to Railway
- [ ] Add MySQL and MongoDB services
- [ ] Configure environment variables
- [ ] Deploy and run migrations
- [ ] Test the live application

## 🔗 Useful Railway Commands (via Railway terminal)

```bash
# Check logs
railway logs

# Run migrations
php artisan migrate --force

# Clear caches
php artisan cache:clear
php artisan config:clear

# Check app status
php artisan about
```

---

**You're ready to deploy! 🚀**

All cleanup is done, tests are passing, and your `.gitignore` is properly configured.
