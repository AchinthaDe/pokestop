# 🎨 POKÉSTOP CSS GUIDE

## Easy CSS Structure - Now Simple to Understand!

### 📁 File Location
- **Main CSS:** `resources/css/app.css`
- **Backup:** `resources/css/app-backup.css` (old messy version)

---

## 🎯 How to Make Changes

### 🌈 Change Colors (Most Common)
Look for the `:root` section at the top:
```css
:root {
  --green: #22c55e;        /* Main green color */
  --green-light: #4ade80;  /* Lighter green */
  --cyan: #00ffff;         /* Cyan/aqua color */
  --yellow: #ffff00;       /* Yellow for badges */
  --blue-dark: #1e3a5f;    /* Background blue */
}
```

**To change the main theme color:** Just change `--green` value!

### 🎴 Modify Product Cards
Look for the `/* PRODUCT CARDS */` section:
- `.product-card` = Main card container
- `.product-title` = Pokemon card name
- `.product-price` = Price styling
- `.product-image` = Image styling

### 🔍 Modify Filters
Look for the `/* FILTERS */` section:
- `.filter-panel` = The filter container
- `.filter-input` = Text input boxes
- `.filter-select` = Dropdown menus

### 📱 Modify Navigation
Look for the `/* NAVIGATION */` section:
- `.nav-link` = Navigation buttons
- `.cart-badge` = Cart number badge

---

## 🔧 Common Customizations

### Make Cards Bigger
```css
.product-card {
  padding: 32px; /* Change from 24px */
}
```

### Change Glow Effects
```css
:root {
  --glow-effect: 0 0 12px; /* Change from 8px */
}
```

### Different Background
```css
body {
  background: linear-gradient(135deg, #your-color1 0%, #your-color2 100%);
}
```

### Rounded Corners
```css
.product-card {
  border-radius: 16px; /* Change from 8px */
}
```

---

## 📱 Responsive Design
The CSS automatically handles mobile devices! Look for:
```css
@media (max-width: 640px) {
  /* Mobile styles here */
}
```

---

## 🚫 What NOT to Touch
- The `@import` lines at the top (needed for Tailwind)
- The media queries (unless you know CSS)
- The keyframe animations (unless you want to break effects)

---

## ✅ After Making Changes
Always run:
```bash
npm run build
```

This compiles your CSS changes!

---

## 🎯 Quick Color Themes

### Purple Theme
```css
--green: #8b5cf6;
--cyan: #a78bfa;
--blue-dark: #4c1d95;
```

### Red Theme
```css
--green: #ef4444;
--cyan: #f87171;
--blue-dark: #7f1d1d;
```

### Orange Theme
```css
--green: #f97316;
--cyan: #fb923c;
--blue-dark: #9a3412;
```

---

## 🆘 Need Help?
The CSS is now organized into clear sections with comments like:
- `/* 🎨 COLOR VARIABLES */`
- `/* 🎴 PRODUCT CARDS */`
- `/* 🔘 BUTTONS */`

Just find the section you want to modify!
