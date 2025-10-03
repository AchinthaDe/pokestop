# Quick Reference Card - PokéStop Styling

## 🎨 Most Used Classes

### Cards
```html
<div class="px-card">
  <h3 class="px-card-title">Title</h3>
  <p class="px-card-meta">Metadata</p>
</div>
```

### Buttons
```html
<button class="px-btn">Default</button>
<button class="px-btn px-btn-primary">Primary</button>
<button class="px-btn px-btn-danger">Delete</button>
<button class="px-btn px-btn-sm">Small</button>
```

### Forms
```html
<div class="px-field">
  <label class="px-label">Label</label>
  <input type="text" class="px-input">
</div>
```

### Grid
```html
<div class="px-grid px-grid-3">
  <!-- 3 columns responsive -->
</div>
```

---

## 🎯 Color Variables (Easy to Change)

```css
:root {
  --px-accent: #5ad1ff;   /* Cyan highlights */
  --px-green: #b4f06a;    /* Headings */
  --px-danger: #ff6363;   /* Errors */
}
```

**To change entire theme:**
1. Open `resources/css/app.css`
2. Find `:root {` section
3. Change hex values
4. Run `npm run build`

---

## 📐 Common Customizations

### Make Everything Bigger
```css
body { font-size: 17px; }  /* Default: 15px */
```

### More Rounded Corners
```css
:root {
  --px-radius: 12px;  /* Default: 6px */
}
```

### Faster Animations
```css
:root {
  --px-transition: 0.15s cubic-bezier(0.25, 0.6, 0.25, 1);
}
```

### Different Accent Color (Red Theme)
```css
:root {
  --px-accent: #ff6b6b;
  --px-accent-soft: #ffb3b3;
}
```

---

## 🔧 File Locations

- **CSS:** `resources/css/app.css`
- **Backup:** `resources/css/app.css.backup`
- **Guide:** `STYLE_GUIDE.md`
- **Summary:** `CSS_REFACTOR_SUMMARY.md`

---

## 🚀 Build Commands

```powershell
# Development (watch mode)
npm run dev

# Production (minified)
npm run build
```

---

## 📱 Responsive Breakpoints

- **Mobile:** < 640px (1 column)
- **Tablet:** 640px - 1023px (2 columns)
- **Desktop:** ≥ 1024px (3-4 columns)

---

## 🎭 Utility Classes

```html
<p class="px-muted">Muted text</p>
<p class="px-accent-text">Accent color</p>
<p class="px-green-text">Green text</p>
<div class="px-center">Centered</div>
<div class="px-grid-full">Full width in grid</div>
```

---

## 🐛 Troubleshooting

### Changes Not Showing?
1. Clear cache (Ctrl+F5)
2. Run `npm run build`
3. Hard refresh browser

### Wrong Colors?
- Check `:root` variables, not individual classes

### Animation Not Working?
- Check browser's reduced-motion setting

---

## 📚 Full Documentation

See **STYLE_GUIDE.md** for:
- Complete component library
- All color swatches
- Typography scale
- Performance tips
- Code examples

---

**Pro Tip:** Keep `app.css.backup` safe! It's your rollback point.
