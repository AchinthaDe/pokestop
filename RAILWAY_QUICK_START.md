# Railway Deployment Quick Checklist

## 🎯 Essential Steps (5 minutes)

### 1️⃣ Create Railway Project
- Go to railway.app → New Project
- Deploy from GitHub → Select `pokestop` repo

### 2️⃣ Add Databases
- Click "+ New" → Add MySQL
- Click "+ New" → Add MongoDB

### 3️⃣ Set Environment Variables
Click App Service → Variables → Add:
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.up.railway.app

DB_CONNECTION=mysql
DB_HOST=${MYSQL_HOST}
DB_PORT=${MYSQL_PORT}
DB_DATABASE=${MYSQL_DATABASE}
DB_USERNAME=${MYSQL_USER}
DB_PASSWORD=${MYSQL_PASSWORD}

MONGODB_URI=${MONGO_URL}

SESSION_DRIVER=database
CACHE_STORE=database
```

### 4️⃣ Deploy
- Railway auto-deploys on setup
- Wait for "Deployment successful"

### 5️⃣ Initialize Database
Open Railway Shell (⋮ menu → Shell):
```bash
php artisan migrate --force
php artisan db:seed --force
```

### 6️⃣ Test
Visit: `https://your-app.up.railway.app`

Login:
- Admin: admin@admin.com / password
- User: test@example.com / password

---

## ✅ Success Indicators
- [ ] Homepage loads
- [ ] 20 Pokemon cards visible on /browse
- [ ] Images show from pocketslabs.com
- [ ] Can login as admin
- [ ] Admin dashboard accessible
- [ ] Cart and checkout work

## 🐛 If Something Breaks
1. Check Railway logs
2. Set APP_DEBUG=true temporarily
3. See full guide: RAILWAY_DEPLOYMENT_GUIDE.md

**Total Time:** 5-10 minutes
**Cost:** $5/month Railway credit (free trial available)
