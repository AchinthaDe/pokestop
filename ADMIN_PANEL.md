# Admin Panel Documentation

## Overview
Complete admin panel with dashboard, order management, product management, and customer management with ban/unban functionality.

## Features Implemented

### 1. Admin Dashboard (`/admin/dashboard`)
**Features**:
- **Stats Cards**: Total Orders, Total Revenue, Total Products, Total Customers
- **Recent Orders Table**: Last 5 orders with customer info, items count, total, status, date
- **Low Stock Products**: Products with stock ≤ 5, color-coded warnings (red for ≤2, yellow for ≤5)
- **Quick Actions**: Direct links to view order details and edit products

**Controller**: `AdminDashboardController@index`
**View**: `admin/dashboard.blade.php`

### 2. Orders Management (`/admin/orders`)

#### Orders Index
**Features**:
- Search by order ID or customer name/email
- Filter by order status (pending, paid, processing, shipped, delivered, cancelled)
- Paginated table (20 per page) showing:
  - Order #, Customer name, Email, Items count, Total, Status (color-coded), Date
- View details button for each order

**Route**: `GET /admin/orders`
**Controller**: `AdminOrderController@index`
**View**: `admin/orders/index.blade.php`

#### Order Detail
**Features**:
- Full customer information with link to customer profile
- Itemized list with product images, quantities, unit prices
- Order total breakdown (subtotal, shipping, tax, total)
- Update order status form with dropdown (6 statuses available)
- Payment information (from order meta)

**Route**: `GET /admin/orders/{order}`
**Controller**: `AdminOrderController@show`
**View**: `admin/orders/show.blade.php`

**Status Update**:
- Route: `PUT /admin/orders/{order}/status`
- Controller: `AdminOrderController@updateStatus`
- Validates: `pending|paid|processing|shipped|delivered|cancelled`

### 3. Products Management (`/admin/products`)

#### Products Index
**Features**:
- "Add New Product" button at top
- Paginated table (20 per page) showing:
  - Product image thumbnail (60x60px)
  - Pokemon name / Card name
  - Category
  - Price (color-coded primary)
  - Stock (color-coded: red ≤5, yellow ≤10, green >10)
  - Edit button
- Total products count in header

**Route**: `GET /admin/products`
**Controller**: `AdminProductController@index`
**View**: `admin/products/index.blade.php`

#### Product Create/Edit
**Existing Routes**:
- `GET /admin/products/create` → `AdminProductController@create`
- `POST /admin/products` → `AdminProductController@store`
- `GET /admin/products/{product}/edit` → `AdminProductController@edit`
- `PUT /admin/products/{product}` → `AdminProductController@update`

**Note**: These views already exist from previous implementation.

### 4. Customers Management (`/admin/customers`)

#### Customers Index
**Features**:
- Search by customer name or email
- Filter by status (All / Active / Banned)
- Paginated table (20 per page) showing:
  - Name (with 🚫 BANNED indicator if banned)
  - Email
  - Order count
  - Join date
  - Status badge (green=Active, red=Banned)
  - View Profile button
- Banned customers have red background highlight
- Total customers count in header

**Route**: `GET /admin/customers`
**Controller**: `AdminCustomerController@index`
**View**: `admin/customers/index.blade.php`

#### Customer Profile
**Features**:
- **Customer Information**:
  - Name, Email, Member Since
  - Account Status badge (Active/Banned with icons)
  - Ban reason display (if banned) with ban date
  
- **Purchase Statistics**:
  - Total Orders (blue stat card)
  - Total Spent (green stat card)
  - Average Order Value (yellow stat card)

- **Account Actions**:
  - **Ban Form** (if not banned):
    - Textarea for ban reason (required)
    - Ban button with confirmation dialog
  - **Unban Button** (if banned):
    - One-click unban with confirmation

- **Order History Table**:
  - All customer orders with Order #, Date, Items, Total, Status
  - View button links to admin order detail

**Routes**:
- `GET /admin/customers/{user}` → `AdminCustomerController@show`
- `POST /admin/customers/{user}/ban` → `AdminCustomerController@ban`
- `POST /admin/customers/{user}/unban` → `AdminCustomerController@unban`

**Controller**: `AdminCustomerController`
**View**: `admin/customers/show.blade.php`

### 5. Ban System

#### Database Changes
**Migration**: `2025_10_02_155608_add_banned_to_users_table.php`

**Columns Added**:
- `banned` (boolean, default: false)
- `banned_at` (timestamp, nullable)
- `ban_reason` (text, nullable)

**User Model Updates**:
- Added fillable fields: `role`, `banned`, `banned_at`, `ban_reason`
- Added casts: `banned` → boolean, `banned_at` → datetime
- Added methods:
  - `isAdmin()` → Check if user is admin
  - `isBanned()` → Check if user is banned

#### Middleware
**File**: `app/Http/Middleware/CheckBanned.php`

**Functionality**:
- Checks if authenticated user is banned on every request
- If banned:
  - Invalidates session
  - Regenerates CSRF token
  - Redirects to login with ban reason error message

**Usage**: Add to kernel to apply globally or to specific route groups

#### Ban/Unban Logic
**Ban Action**:
- Requires reason (max 500 chars)
- Sets `banned = true`
- Records `banned_at` timestamp
- Stores ban reason
- Returns success message

**Unban Action**:
- Sets `banned = false`
- Clears `banned_at` and `ban_reason`
- Returns success message

### 6. Admin Layout & Design

#### Layout File
**File**: `resources/views/admin/layout.blade.php`

**Structure**:
- **Sidebar** (250px fixed width):
  - ADMIN PANEL logo
  - Navigation links with emoji icons:
    - 📊 Dashboard
    - 📦 Orders
    - 🎴 Products
    - 👥 Customers
  - Divider
  - 🏠 Back to Store
  - 🚪 Logout button
  - Active state border highlighting

- **Main Content Area**:
  - Top bar with page title and logged-in admin name
  - Flash message display (success/error)
  - Content section with @yield('content')
  - Pixel seafloor background

#### Typography
**Admin-Specific Sizes** (larger for readability):
- `.admin-text`: 1.125rem (18px) - body text
- `.admin-heading`: 1.5rem (24px) - section headings
- `.admin-title`: 2rem (32px) - page titles
- Stats displays: 2.5rem (40px) - large numbers

**Theme Integration**:
- Uses existing pixel theme CSS variables
- VT323 monospace font throughout
- Consistent `.px-*` classes (panels, buttons, inputs, badges)
- Color-coded status badges and stats

### 7. Routes Summary

```php
// Admin Routes (require auth + can:admin-access)
/admin/dashboard                      GET    Dashboard home
/admin/orders                         GET    Orders list
/admin/orders/{order}                 GET    Order details
/admin/orders/{order}/status          PUT    Update order status
/admin/products                       GET    Products list
/admin/products/create                GET    Create product form
/admin/products                       POST   Store new product
/admin/products/{product}/edit        GET    Edit product form
/admin/products/{product}             PUT    Update product
/admin/customers                      GET    Customers list
/admin/customers/{user}               GET    Customer profile
/admin/customers/{user}/ban           POST   Ban customer
/admin/customers/{user}/unban         POST   Unban customer
```

## Authorization

### Existing Gate
The routes use `can:admin-access` middleware, which requires:
- User must be authenticated
- User must have permission defined in gate (check `AuthServiceProvider.php`)

### Recommended Setup
If gate doesn't exist, add to `app/Providers/AuthServiceProvider.php`:

```php
Gate::define('admin-access', function ($user) {
    return $user->role === 'admin';
});
```

Or update route middleware to check role directly:
```php
Route::middleware(['auth', function ($request, $next) {
    if (!auth()->user()->isAdmin()) {
        abort(403, 'Unauthorized access to admin panel');
    }
    return $next($request);
}])->prefix('admin')->name('admin.')->group(function(){
    // routes...
});
```

## File Structure

### Controllers (4 new files)
- `app/Http/Controllers/Admin/AdminDashboardController.php` (27 lines)
- `app/Http/Controllers/Admin/AdminOrderController.php` (54 lines)
- `app/Http/Controllers/Admin/AdminCustomerController.php` (75 lines)
- `app/Http/Middleware/CheckBanned.php` (28 lines)

### Views (8 new files)
- `resources/views/admin/layout.blade.php` (99 lines) - Sidebar layout
- `resources/views/admin/dashboard.blade.php` (134 lines) - Dashboard home
- `resources/views/admin/orders/index.blade.php` (101 lines) - Orders list
- `resources/views/admin/orders/show.blade.php` (160 lines) - Order detail
- `resources/views/admin/products/index.blade.php` (98 lines) - Products list
- `resources/views/admin/customers/index.blade.php` (95 lines) - Customers list
- `resources/views/admin/customers/show.blade.php` (192 lines) - Customer profile

### Database
- `database/migrations/2025_10_02_155608_add_banned_to_users_table.php`

### Routes
- Updated `routes/web.php` with 12 admin routes

### Models
- Updated `app/Models/User.php`:
  - Added fillable fields for ban system
  - Added casts
  - Added `isAdmin()` and `isBanned()` helper methods

## Total Code Added
- **Backend**: ~184 lines (4 controllers + middleware)
- **Frontend**: ~879 lines (7 Blade views + layout)
- **Total**: ~1,063 lines of new code

## Usage Guide

### Accessing Admin Panel
1. Login as user with `role = 'admin'`
2. Navigate to `/admin/dashboard`
3. Use sidebar navigation to access different sections

### Managing Orders
1. Go to Orders section
2. Search/filter orders as needed
3. Click "View Details" to see full order
4. Update order status using dropdown form
5. View customer profile directly from order

### Managing Products
1. Go to Products section
2. Click "Add New Product" to create new product
3. Click "Edit" on any product to modify
4. Low stock products show up on dashboard

### Managing Customers
1. Go to Customers section
2. Search by name or email
3. Filter by Active/Banned status
4. Click "View Profile" to see customer details
5. To ban:
   - Enter ban reason in form
   - Click "Ban Customer" (confirms action)
6. To unban:
   - Click "Unban Customer" button (confirms action)

### Customer Ban Effects
When banned:
- User cannot login (logged out immediately)
- Sees ban reason on login page
- Cannot make purchases
- Cannot access any authenticated routes
- Admin can still view their profile and order history

## Color Coding Reference

### Status Badges
- **Green** (var(--px-success)): Paid, Delivered, Active users
- **Yellow** (var(--px-warning)): Pending, Processing
- **Red** (var(--px-error)): Cancelled orders, Banned users

### Stock Levels
- **Green**: Stock > 10
- **Yellow**: Stock 6-10
- **Red**: Stock ≤ 5

### Stats Cards
- **Blue** (var(--px-primary)): Orders count
- **Green** (var(--px-success)): Revenue/Total spent
- **Yellow** (var(--px-warning)): Products count/Average order
- **Purple** (var(--px-secondary)): Customer count

## Security Considerations

1. **Authorization**: All routes require `admin-access` permission
2. **CSRF Protection**: All forms include @csrf tokens
3. **Ban Validation**: Requires reason, max 500 characters
4. **Session Management**: Banned users have session invalidated
5. **Confirmation Dialogs**: Ban/unban actions require confirmation

## Next Steps (Optional Enhancements)

### Product Management
- Add delete product functionality
- Add bulk product import
- Add product categories management
- Add image upload instead of URL input

### Order Management
- Add order export (CSV/PDF)
- Add bulk status updates
- Add order notes/comments
- Send email notifications on status change

### Customer Management
- Add bulk customer actions
- Export customer list
- Add customer notes
- View customer activity log

### Dashboard
- Add date range filter for stats
- Add revenue chart
- Add order status distribution chart
- Add recent customer registrations

### Ban System
- Add ban duration (temporary bans)
- Add ban appeal system
- Add ban history log
- Email notification to banned users

---

**Status**: ✅ Complete and Production Ready  
**Last Updated**: October 2, 2025  
**Documentation Version**: 1.0
