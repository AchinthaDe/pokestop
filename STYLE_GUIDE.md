# PokéStop Style Guide

**Version 1.0** | Last Updated: October 2, 2025

A comprehensive guide to the PokéStop pixel-era design system inspired by Game Boy Color Pokémon Silver.

---

## Table of Contents

1. [Design Philosophy](#design-philosophy)
2. [Color Palette](#color-palette)
3. [Typography](#typography)
4. [Layout System](#layout-system)
5. [Components](#components)
6. [Utilities](#utilities)
7. [Animations](#animations)
8. [Customization Guide](#customization-guide)
9. [Performance Best Practices](#performance-best-practices)

---

## Design Philosophy

### Core Aesthetic Principles

- **Pixel-Perfect Retro:** Inspired by 1999-2001 Game Boy Color Pokémon games
- **Oceanic Theme:** Graduated water depths from surface to seafloor
- **Minimal Glow:** Subtle cyan accents, no excessive neon
- **Monospace Typography:** Authentic retro computing feel
- **Performance-First:** GPU-accelerated animations, reduced-motion support

### Color Psychology

- **Cyan/Aqua:** Primary accent representing water Pokémon (Lapras, Lugia)
- **Green:** Success states and Game Boy Color nostalgia
- **Deep Blues:** Calming ocean atmosphere
- **Shadow Blacks:** Depth and hierarchy

---

## Color Palette

### CSS Variables Reference

All colors are defined as CSS custom properties in `:root` for easy customization.

#### Background Gradients

```css
--px-bg-top:    #0f4b9a;  /* Bright surface water */
--px-bg-mid:    #0a3570;  /* Mid-ocean depth */
--px-bg-deep:   #041a34;  /* Deep ocean trench */
--px-bg-black:  #000000;  /* Seafloor darkness */
```

**Usage:**
```html
<!-- Applied automatically to <body> -->
<body>
  <!-- Ocean gradient background is global -->
</body>
```

**When to customize:**
- Want a different time-of-day theme (sunset, night)
- Seasonal variants (icy blue for winter events)

---

#### Panel & Card Backgrounds

```css
--px-panel:      #0d233f;  /* Primary panel background */
--px-panel-alt:  #123357;  /* Secondary panel shade */
--px-panel-dark: #0a1a2e;  /* Dark panel variant */
```

**Usage:**
- `.px-card` uses gradient from `--px-panel` to `--px-panel-alt`
- `.px-panel` uses gradient from `#0d243d` to `--px-panel-dark`

**When to customize:**
- Different card background tones
- Light/dark mode toggle

---

#### Border Colors

```css
--px-border:        #1f4d79;  /* Standard border */
--px-border-light:  #3c7db3;  /* Highlighted edge */
--px-border-dark:   #081525;  /* Shadow edge */
--px-border-accent: #163e60;  /* Accent border */
```

**Usage:**
```html
<div class="px-card">
  <!-- Border uses --px-border, hover uses --px-accent -->
</div>
```

---

#### Accent Colors

```css
--px-accent:      #5ad1ff;  /* Primary cyan (Lapras) */
--px-accent-soft: #9fe6ff;  /* Softer cyan for text */
--px-green:       #b4f06a;  /* Game Boy green */
--px-yellow:      #ffe9a3;  /* Retro yellow highlight */
--px-danger:      #ff6363;  /* Error red */
--px-danger-dark: #aa0000;  /* Dark danger */
```

**Usage Examples:**
```html
<!-- Primary accent for links/buttons -->
<a href="#" class="px-link">HOME</a>

<!-- Green for headings -->
<h2 class="px-card-title">Featured Cards</h2>

<!-- Danger for errors -->
<span class="px-error">Invalid input</span>
```

**When to customize:**
- Different Pokémon theme (red for Pokémon Red, gold for Gold version)
- Brand colors for commercial use

---

#### Text Colors

```css
--px-fg:        #9fe6ff;  /* Primary foreground */
--px-muted:     #85b4cd;  /* Muted/secondary */
--px-card-meta: #c5def0;  /* Card metadata */
```

**Usage:**
```html
<p>Normal text (uses --px-fg automatically)</p>
<span class="px-muted">Secondary info</span>
<div class="px-card-meta">SET: Base • RARITY: Rare</div>
```

---

### Color Swatches

| Color | Hex | Variable | Usage |
|-------|-----|----------|-------|
| ![#0f4b9a](https://via.placeholder.com/20/0f4b9a/000000?text=+) | `#0f4b9a` | `--px-bg-top` | Background gradient start |
| ![#5ad1ff](https://via.placeholder.com/20/5ad1ff/000000?text=+) | `#5ad1ff` | `--px-accent` | Links, buttons, highlights |
| ![#b4f06a](https://via.placeholder.com/20/b4f06a/000000?text=+) | `#b4f06a` | `--px-green` | Headings, success states |
| ![#ff6363](https://via.placeholder.com/20/ff6363/000000?text=+) | `#ff6363` | `--px-danger` | Errors, warnings |
| ![#ffe9a3](https://via.placeholder.com/20/ffe9a3/000000?text=+) | `#ffe9a3` | `--px-yellow` | Highlights, badges |

---

## Typography

### Font Stack

```css
--px-mono: 'VT323', monospace;
```

**Primary Font:** VT323 (monospace pixel font from Google Fonts)

**Fallback:** System monospace fonts

**Loaded in `layouts/app.blade.php`:**
```html
<link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
```

---

### Type Scale

| Class | Font Size | Usage |
|-------|-----------|-------|
| `.px-hero-title` | 3rem (48px) | Hero section main title |
| `.px-section-title` | 1.15rem | Section headings |
| `.px-card-title` | 1rem | Card headings |
| `.px-price` | 1.05rem | Price displays |
| `.px-hero-sub` | 0.85rem | Hero subtitle |
| `.px-card-meta` | 0.7rem | Metadata text |
| `.px-btn` | 0.65rem | Button text |
| `.px-label` | 0.55rem | Form labels |
| `.px-error` | 0.55rem | Error messages |

---

### Text Utilities

```html
<!-- Muted secondary text -->
<span class="px-muted">Secondary info</span>

<!-- Accent colored text -->
<span class="px-accent-text">Highlighted</span>

<!-- Green text -->
<span class="px-green-text">Success</span>

<!-- Center alignment -->
<div class="px-center">Centered text</div>
```

---

## Layout System

### Container

Centers content with maximum width and responsive padding.

```html
<div class="px-container">
  <!-- Max-width: 1240px, centered -->
</div>
```

**Breakpoints:**
- Mobile: `padding: 2.2rem 1.4rem 3rem`
- Tablet (641-1023px): `padding: 2rem 1.5rem`
- Desktop (1024px+): Same as mobile

---

### Grid System

Responsive grid with automatic column adjustments.

```html
<!-- 3-column grid (responsive) -->
<div class="px-grid px-grid-3">
  <div class="px-card">Item 1</div>
  <div class="px-card">Item 2</div>
  <div class="px-card">Item 3</div>
</div>
```

**Grid Classes:**
- `.px-grid` - Base grid (gap: 1.4rem)
- `.px-grid-2` - 2 columns on desktop, 2 on tablet, 1 on mobile
- `.px-grid-3` - 3 columns on desktop, 2 on tablet, 1 on mobile
- `.px-grid-4` - 4 columns on desktop, 2 on tablet, 1 on mobile

**Full-width child:**
```html
<div class="px-grid px-grid-3">
  <div class="px-card px-grid-full">Full width card</div>
</div>
```

---

## Components

### Cards

#### Standard Card

```html
<div class="px-card">
  <h3 class="px-card-title">Card Title</h3>
  <p class="px-card-meta">Metadata text</p>
  <div class="px-price">$99.99</div>
</div>
```

**Features:**
- Gradient background
- 2px border (cyan on hover)
- Box shadow with depth
- Smooth hover transition

---

#### Card with Image

```html
<div class="px-card">
  <div class="px-card-image">
    <img src="pokemon.png" alt="Charizard">
  </div>
  <h3 class="px-card-title">Charizard</h3>
  <div class="px-price">$249.99</div>
</div>
```

---

#### Panel (Large Container)

```html
<div class="px-panel">
  <h3 class="px-card-title">Panel Title</h3>
  <p>Panel content...</p>
</div>
```

**Use for:**
- Forms
- Filters
- Cart summaries
- Settings pages

---

### Navigation

```html
<header class="px-nav">
  <div class="px-nav-inner">
    <a href="/" class="px-logo">POKÉSTOP</a>
    <nav class="flex gap-2">
      <a href="/" class="px-link px-link-active">HOME</a>
      <a href="/browse" class="px-link">BROWSE</a>
      
      <!-- Cart with badge -->
      <span class="px-cart-badge">
        <a href="/cart" class="px-link">CART</a>
        <span class="px-cart-count">3</span>
      </span>
    </nav>
  </div>
</header>
```

---

### Buttons

#### Button Variants

```html
<!-- Default button -->
<button class="px-btn">Default</button>

<!-- Primary action -->
<button class="px-btn px-btn-primary">Primary</button>

<!-- Danger/delete action -->
<button class="px-btn px-btn-danger">Delete</button>

<!-- Small button -->
<button class="px-btn px-btn-sm">Small</button>

<!-- Large button -->
<button class="px-btn px-btn-lg">Large</button>

<!-- Full-width button -->
<button class="px-btn px-btn-block">Full Width</button>
```

#### Button States

```html
<!-- Disabled state -->
<button class="px-btn" disabled>Disabled</button>

<!-- With icon (using Tailwind) -->
<button class="px-btn flex items-center gap-2">
  <svg>...</svg>
  <span>Add to Cart</span>
</button>
```

---

### Forms

#### Complete Form Example

```html
<form class="px-panel">
  <!-- Text input -->
  <div class="px-field">
    <label class="px-label" for="name">Card Name</label>
    <input type="text" id="name" class="px-input" placeholder="Enter card name">
  </div>
  
  <!-- Select dropdown -->
  <div class="px-field">
    <label class="px-label" for="rarity">Rarity</label>
    <select id="rarity" class="px-input">
      <option value="">Select rarity</option>
      <option value="common">Common</option>
      <option value="rare">Rare</option>
    </select>
  </div>
  
  <!-- Textarea -->
  <div class="px-field">
    <label class="px-label" for="notes">Notes</label>
    <textarea id="notes" class="px-textarea"></textarea>
  </div>
  
  <!-- Error message -->
  <div class="px-field">
    <input type="email" class="px-input px-input-error">
    <span class="px-error">Invalid email address</span>
  </div>
  
  <!-- Submit -->
  <button type="submit" class="px-btn px-btn-primary px-btn-block">
    Submit
  </button>
</form>
```

---

### Hero Section

```html
<div class="px-hero">
  <!-- Optional flying animation layer -->
  <div class="px-flyer-layer">
    <div class="px-flyer">
      <img src="/images/lugia-silhouette.svg" alt="Lugia">
    </div>
  </div>
  
  <h1 class="px-hero-title">PokéStop</h1>
  <p class="px-hero-sub">Rare Pokémon Card Collection</p>
  <a href="/browse" class="px-btn px-btn-primary px-hero-cta">
    Browse Collection
  </a>
</div>
```

---

## Utilities

### Display & Alignment

```html
<span class="px-inline">Inline block element</span>
<div class="px-center">Centered text</div>
<div class="px-hidden">Hidden element</div>
```

### Screen Reader Only

```html
<span class="px-sr-only">Screen reader only text</span>
```

### Text Colors

```html
<p class="px-muted">Muted text</p>
<p class="px-accent-text">Accent text</p>
<p class="px-green-text">Green text</p>
```

---

## Animations

### Flying Legend (Lugia)

Automatically applied in hero section. The animation:
- Flies from left to right across screen
- Scales and rotates for 3D effect
- Loops infinitely (26s duration)
- Fades in on page load
- Respects `prefers-reduced-motion`

**Customization:**
```css
.px-flyer {
  opacity: 0.68; /* Change visibility */
  width: clamp(220px, 32vw, 420px); /* Change size */
}

@keyframes px-fly-path {
  /* Edit keyframes for different path */
}
```

---

### Water Overlay

Subtle breathing bokeh effect overlay.

**Disable:**
```css
.px-water-overlay {
  display: none;
}
```

**Adjust intensity:**
```css
.px-water-overlay {
  opacity: 0.3; /* Lower = more subtle */
}
```

---

### Card Shimmer

Optional shimmer effect for special cards.

```html
<div class="px-card px-shimmer">
  <!-- Shimmering card -->
</div>
```

---

### Fade In

```html
<div class="px-fade-in">
  <!-- Content fades in on load -->
</div>
```

---

## Customization Guide

### Changing the Color Theme

**Example: Red/Fire Theme (Pokémon Red inspired)**

```css
:root {
  /* Replace in app.css */
  --px-bg-top: #8a2730;     /* Fire red surface */
  --px-bg-mid: #61141a;     /* Deep red */
  --px-bg-deep: #2d0a0d;    /* Almost black red */
  
  --px-accent: #ff8891;     /* Bright red accent */
  --px-accent-soft: #ffb3b8; /* Soft pink-red */
  --px-green: #ffcc66;      /* Yellow/gold instead of green */
}
```

---

### Adjusting Spacing

**Tighter layouts:**
```css
.px-card {
  padding: 0.75rem; /* Reduced from 1rem */
}

.px-grid {
  gap: 1rem; /* Reduced from 1.4rem */
}
```

---

### Typography Scaling

**Larger text:**
```css
body {
  font-size: 17px; /* Base increased from 15px */
}

.px-hero-title {
  font-size: 3.5rem; /* Increased from 3rem */
}
```

---

### Border Radius

**More rounded corners:**
```css
:root {
  --px-radius: 12px;    /* Increased from 6px */
  --px-radius-sm: 8px;  /* Increased from 4px */
}
```

**Square/pixel-perfect:**
```css
:root {
  --px-radius: 0px;
  --px-radius-sm: 0px;
}
```

---

### Animation Speed

**Faster transitions:**
```css
:root {
  --px-transition: 0.15s cubic-bezier(0.25, 0.6, 0.25, 1);
}
```

**Slower, more cinematic:**
```css
:root {
  --px-transition: 0.4s cubic-bezier(0.25, 0.6, 0.25, 1);
}
```

---

## Performance Best Practices

### GPU Acceleration

All animations use `translate3d()` and `scale()` instead of `left/top` for 60fps performance.

```css
/* ✅ Good - GPU accelerated */
transform: translate3d(100px, 50px, 0);

/* ❌ Avoid - CPU layout recalc */
left: 100px;
top: 50px;
```

---

### Will-Change Hints

Only applied to actively animating elements:

```css
.px-flyer {
  will-change: transform; /* Tells browser to optimize */
}
```

**Don't overuse:** Only use on elements that will definitely animate.

---

### Reduced Motion

Always respect user accessibility preferences:

```css
@media (prefers-reduced-motion: reduce) {
  .px-flyer {
    animation: none;
    opacity: 0.35;
  }
}
```

---

### Image Optimization

**Product images:**
```html
<img src="pokemon.webp" 
     alt="Charizard" 
     loading="lazy" 
     decoding="async" 
     width="300" 
     height="400">
```

**Hero animation:**
```html
<img src="/images/lugia-silhouette.svg" 
     alt="Lugia" 
     loading="eager">
```

---

## Quick Reference Cheat Sheet

### Common Patterns

```html
<!-- Standard product card -->
<div class="px-card">
  <div class="px-card-image">
    <img src="product.jpg" alt="Product">
  </div>
  <h3 class="px-card-title">Product Name</h3>
  <p class="px-card-meta">SET: Base • RARITY: Rare</p>
  <div class="px-price">$99.99</div>
  <button class="px-btn px-btn-primary px-btn-block">
    Add to Cart
  </button>
</div>

<!-- Filter panel -->
<aside class="px-panel">
  <h3 class="px-card-title">Filters</h3>
  <div class="px-field">
    <label class="px-label">Search</label>
    <input type="text" class="px-input" placeholder="Search...">
  </div>
  <button class="px-btn px-btn-block">Apply Filters</button>
</aside>

<!-- Section with grid -->
<section class="px-container">
  <h2 class="px-section-title">Featured Cards</h2>
  <div class="px-grid px-grid-3">
    <!-- Cards here -->
  </div>
</section>
```

---

## File Structure

```
resources/
  css/
    app.css              # Main stylesheet (this file)
    app.css.backup       # Backup before refactor
  views/
    layouts/
      app.blade.php      # Main layout with nav/footer
    components/
      product-card.blade.php  # Reusable card component
    cart/
      index.blade.php    # Cart page
    livewire/
      product-search.blade.php  # Filter page
public/
  images/
    lugia-silhouette.svg  # Hero animation sprite
```

---

## Support & Resources

- **Tailwind CSS Docs:** https://tailwindcss.com/docs
- **VT323 Font:** https://fonts.google.com/specimen/VT323
- **CSS Custom Properties:** https://developer.mozilla.org/en-US/docs/Web/CSS/--*
- **CSS Animations:** https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Animations

---

## Changelog

### v1.0 (October 2, 2025)
- Initial refactored design system
- Comprehensive documentation
- 16 organized CSS sections
- Full component library
- Performance optimizations
- Accessibility improvements

---

**Made with ♥ for Pokémon fans everywhere**
