# CSS Refactoring Summary

## What Was Done

### 1. **Code Organization**
The original `app.css` had:
- 613 lines of mixed styles
- Duplicate/legacy classes (pk-*, retro-*, old terminal theme remnants)
- Inline styles scattered across Blade templates
- No clear structure or comments

### 2. **Refactored Structure** (16 Organized Sections)

```
1. Design Tokens (CSS Variables)      - All colors, fonts, spacing in :root
2. Base Styles                         - html, body global settings
3. Layout Components                   - Container, grid system
4. Atmospheric Effects                 - Water overlay, seafloor
5. Navigation                          - Nav bar, links, cart badge
6. Cards & Panels                      - Product cards, panels, section titles
7. Buttons                            - All button variants and sizes
8. Forms & Inputs                      - Labels, inputs, selects, errors
9. Hero Section                        - Hero title, subtitle, CTA
10. Flying Legend Animation            - Lugia animation keyframes
11. Footer                             - Footer styles
12. Cart-Specific Styles               - Cart empty, cart items, summary
13. Utility Classes                    - Text colors, alignment, helpers
14. Responsive Utilities               - Mobile breakpoints
15. Animations & Transitions           - Shimmer, fade-in effects
16. Print Styles                       - Printer-friendly overrides
```

### 3. **Inline Styles Extracted**

**Before:**
```html
<a href="/browse" class="px-btn" style="min-width:260px;">Browse</a>
<div class="px-muted" style="font-size:.55rem; letter-spacing:1px;">Range</div>
<div class="px-card" style="padding:3rem;">Empty cart</div>
```

**After:**
```html
<a href="/browse" class="px-btn px-hero-cta">Browse</a>
<div class="px-muted text-xs tracking-wide">Range</div>
<div class="px-card px-cart-empty">Empty cart</div>
```

**New CSS Classes Added:**
- `.px-hero-cta` - Hero CTA button (min-width: 260px)
- `.px-grid-full` - Full-width grid child
- `.px-cart-empty` - Cart empty state padding
- `.px-cart-image` - Cart thumbnail styling
- `.px-cart-summary` - Cart summary section
- `.px-card-image` - Product card image container
- `.px-btn-sm` - Small button variant
- `.px-input-sm` - Small input variant

### 4. **CSS Variables (Easy Customization)**

All design tokens now in `:root`:

```css
:root {
  /* Colors */
  --px-bg-top: #0f4b9a;
  --px-accent: #5ad1ff;
  --px-green: #b4f06a;
  
  /* Typography */
  --px-mono: 'VT323', monospace;
  
  /* Spacing */
  --px-radius: 6px;
  
  /* Transitions */
  --px-transition: 0.22s cubic-bezier(0.25, 0.6, 0.25, 1);
}
```

### 5. **Performance Optimizations**

- ✅ GPU-accelerated animations (`translate3d`, `scale`)
- ✅ `will-change` hints for animating elements
- ✅ `@media (prefers-reduced-motion: reduce)` support
- ✅ Lazy loading hints in documentation
- ✅ Print stylesheet for accessibility

### 6. **Documentation Created**

**STYLE_GUIDE.md** includes:
- Complete color palette with hex codes
- Typography scale reference
- Grid system documentation
- Component usage examples
- Customization guide
- Performance best practices
- Quick reference cheat sheet

---

## Files Modified

1. `resources/css/app.css` - **Backup created** (`app.css.backup`)
2. `resources/views/home.blade.php` - Removed inline styles
3. `resources/views/components/product-card.blade.php` - Extracted inline styles
4. `resources/views/livewire/product-search.blade.php` - Removed inline styles
5. `resources/views/cart/index.blade.php` - Extracted cart-specific styles
6. `STYLE_GUIDE.md` - **Created comprehensive guide**

---

## How to Use the Style Guide

### Quick Start

1. **Read the color palette section** to understand available colors
2. **Check the components section** for HTML templates
3. **Use utilities** for quick text/spacing adjustments

### Common Tasks

#### Change Theme Colors

Edit `:root` variables in `app.css`:
```css
:root {
  --px-accent: #ff6b6b; /* Change to red */
  --px-green: #ffd93d;  /* Change to gold */
}
```

#### Add New Component

1. Add to appropriate section (e.g., section 6 for cards)
2. Use existing variables
3. Follow naming convention (`.px-component-variant`)
4. Document in STYLE_GUIDE.md

#### Adjust Spacing

```css
.px-card {
  padding: 1.5rem; /* Increase from 1rem */
}

.px-grid {
  gap: 2rem; /* Increase from 1.4rem */
}
```

---

## CSS Class Naming Convention

### Prefix System

- `.px-*` - PokéStop pixel theme classes
- `.px-btn-*` - Button variants
- `.px-card-*` - Card-related
- `.px-nav-*` - Navigation
- `.px-hero-*` - Hero section
- `.px-grid-*` - Grid system

### Examples

```css
.px-btn              /* Base button */
.px-btn-primary      /* Primary variant */
.px-btn-sm           /* Size modifier */
.px-btn-block        /* Layout modifier */

.px-card             /* Base card */
.px-card-title       /* Card child element */
.px-card-image       /* Card child element */
```

---

## Tailwind Integration

The refactored CSS works **alongside** Tailwind:

```html
<!-- Mix custom classes with Tailwind utilities -->
<div class="px-card flex items-center gap-4">
  <div class="px-card-image">...</div>
  <h3 class="px-card-title mb-2">Title</h3>
</div>
```

**When to use each:**

- **Custom `.px-*` classes:** Theme-specific styling (colors, borders, shadows)
- **Tailwind utilities:** Layout (flex, grid), spacing (mt-4, p-2), responsive (sm:, lg:)

---

## Responsive Design

### Breakpoints

```css
/* Mobile-first approach */
@media (min-width: 640px) {
  /* Tablet styles */
}

@media (min-width: 1024px) {
  /* Desktop styles */
}
```

### Grid Auto-adjusts

```html
<div class="px-grid px-grid-3">
  <!-- 1 column mobile, 2 tablet, 3 desktop -->
</div>
```

---

## Before/After Comparison

### Code Reduction

**Before:**
- 613 lines (mixed, unorganized)
- 12 inline style attributes
- No documentation

**After:**
- ~900 lines (organized, commented)
- 0 inline style attributes (all extracted)
- 500+ line style guide

### Maintainability

**Before:**
```css
/* Scattered throughout file */
.pk-card { ... }
.retro-card { ... }
.y2k-product-card { ... }
.px-card { ... }
```

**After:**
```css
/* Section 6: Cards & Panels */
.px-card { ... }
.px-card-title { ... }
.px-card-image { ... }
```

---

## Quick Fix Guide

### Common Issues

#### "My changes aren't showing"

1. Clear browser cache (Ctrl+F5)
2. Rebuild assets: `npm run build`
3. Check CSS file was saved

#### "Colors look wrong"

Check you're editing `:root` variables, not individual classes:
```css
/* ✅ Good - affects everything */
:root {
  --px-accent: #new-color;
}

/* ❌ Bad - only affects one element */
.px-link {
  color: #new-color;
}
```

#### "Animation not working"

Check `prefers-reduced-motion` setting:
```css
@media (prefers-reduced-motion: reduce) {
  .px-flyer {
    animation: none; /* Animations disabled */
  }
}
```

---

## Next Steps

1. **Read STYLE_GUIDE.md** in full
2. **Experiment** with color variables
3. **Add new components** following the structure
4. **Document** any additions in the style guide
5. **Keep backup** (`app.css.backup`) safe

---

## Support

If you need to:
- **Change colors:** Edit `:root` variables
- **Add components:** Follow section 6 pattern
- **Adjust spacing:** Edit padding/margin values
- **Change fonts:** Update `--px-mono` variable
- **Modify animations:** Edit keyframes in section 10

Refer to **STYLE_GUIDE.md** for detailed examples.

---

**Last Updated:** October 2, 2025  
**Version:** 1.0
