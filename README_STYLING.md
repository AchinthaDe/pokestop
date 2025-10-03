# PokéStop Design System Documentation Index

Welcome to the PokéStop pixel-era design system! This index helps you find what you need quickly.

---

## 📚 Documentation Files

### 1. **STYLE_GUIDE.md** (Main Reference)
**500+ lines** | Comprehensive design system documentation

**Read this for:**
- Complete component library with HTML examples
- Typography scale and font usage
- Layout system (container, grids)
- All CSS class reference
- Customization tutorials
- Performance best practices

**Best for:** Deep dives, learning the system, implementing new features

---

### 2. **QUICK_REFERENCE.md** (Cheat Sheet)
**~100 lines** | Fast lookup for common tasks

**Read this for:**
- Most-used classes at a glance
- Common customization snippets
- Quick troubleshooting
- File locations
- Build commands

**Best for:** Quick lookups while coding

---

### 3. **COLOR_PALETTE.md** (Color Reference)
**~200 lines** | Complete color system

**Read this for:**
- All color hex codes with RGB values
- When to use each color
- Theme variation examples (red, yellow, purple, dark mode)
- Accessibility contrast ratios
- Color psychology

**Best for:** Theming, rebranding, color decisions

---

### 4. **CSS_REFACTOR_SUMMARY.md** (Technical Overview)
**~300 lines** | What changed and why

**Read this for:**
- Before/after comparison
- Code organization structure
- Naming conventions
- Tailwind integration
- Inline styles that were extracted
- Troubleshooting guide

**Best for:** Understanding the refactor, maintenance, technical details

---

### 5. **This File (README_STYLING.md)**
Quick index and getting started guide

---

## 🚀 Getting Started

### First Time Setup
1. Read **QUICK_REFERENCE.md** (5 min)
2. Skim **STYLE_GUIDE.md** sections 1-6 (15 min)
3. Try changing a color in `resources/css/app.css`
4. Run `npm run build` and refresh browser

### Daily Development
1. Keep **QUICK_REFERENCE.md** open in a tab
2. Use **STYLE_GUIDE.md** for copy-paste HTML templates
3. Refer to **COLOR_PALETTE.md** when choosing colors

### Advanced Customization
1. Study **CSS_REFACTOR_SUMMARY.md** structure
2. Read **STYLE_GUIDE.md** customization section
3. Experiment with `:root` variables
4. Keep `app.css.backup` safe!

---

## 🎯 Quick Navigation

### I want to...

#### Change Colors
→ `resources/css/app.css` → Find `:root {` → Edit variables  
→ See **COLOR_PALETTE.md** for hex codes  
→ Run `npm run build`

#### Add a New Component
→ **STYLE_GUIDE.md** Section 5 (Components)  
→ Copy HTML template  
→ Customize with existing classes

#### Fix Broken Styling
→ **QUICK_REFERENCE.md** Troubleshooting section  
→ **CSS_REFACTOR_SUMMARY.md** Common Issues  
→ Check browser console for errors

#### Understand a Class
→ **QUICK_REFERENCE.md** for common ones  
→ **STYLE_GUIDE.md** Section 5-13 for deep dive  
→ `app.css` line comments

#### Make Everything Bigger/Smaller
→ **QUICK_REFERENCE.md** Common Customizations  
→ Edit `body { font-size: 15px; }` in `app.css`

#### Create a Dark Mode
→ **COLOR_PALETTE.md** Theme Variations section  
→ Copy dark mode snippet  
→ Paste in `:root {}`

---

## 📁 File Structure

```
pokestop/
├── resources/
│   ├── css/
│   │   ├── app.css              ← Edit here for styling
│   │   └── app.css.backup       ← Safety backup
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php    ← Main layout (nav/footer)
│       ├── components/
│       │   └── product-card.blade.php
│       ├── cart/
│       │   └── index.blade.php
│       └── livewire/
│           └── product-search.blade.php
├── public/
│   └── images/
│       └── lugia-silhouette.svg  ← Hero animation
├── STYLE_GUIDE.md               ← Main documentation
├── QUICK_REFERENCE.md           ← Cheat sheet
├── COLOR_PALETTE.md             ← Color reference
├── CSS_REFACTOR_SUMMARY.md      ← Technical overview
└── README_STYLING.md            ← This file
```

---

## 🎨 Design System Overview

### Core Principle
**Pixel-Perfect Retro:** Game Boy Color Pokémon Silver (1999-2001) aesthetic

### Key Features
- **Ocean gradient** backgrounds (surface → deep → seafloor)
- **Cyan accent** colors (Lapras/Lugia inspired)
- **Monospace typography** (VT323 font)
- **Minimal glow** effects (no excessive neon)
- **Smooth animations** (GPU-accelerated)

### Technology Stack
- **Tailwind CSS** for utilities (flex, grid, spacing)
- **Custom CSS** for theme styling (colors, components)
- **CSS Variables** for easy customization
- **Livewire** for interactive components

---

## 🔧 Common Tasks Checklist

### Changing Theme Color
- [ ] Open `resources/css/app.css`
- [ ] Find `:root {` (around line 35)
- [ ] Change `--px-accent: #new-color;`
- [ ] Save file
- [ ] Run `npm run build` in terminal
- [ ] Hard refresh browser (Ctrl+F5)

### Adding a New Page
- [ ] Create Blade file in `resources/views/`
- [ ] Use `.px-container` wrapper
- [ ] Use `.px-card` for content blocks
- [ ] Reference **STYLE_GUIDE.md** for HTML templates
- [ ] Test responsiveness (mobile/tablet/desktop)

### Creating a New Component
- [ ] Follow existing `.px-*` naming convention
- [ ] Add to appropriate CSS section (1-16)
- [ ] Use existing variables (`var(--px-accent)`)
- [ ] Document in **STYLE_GUIDE.md**
- [ ] Test hover/active/focus states

---

## 🐛 Troubleshooting

### Styles Not Applying
1. Check file saved
2. Run `npm run build`
3. Clear browser cache (Ctrl+Shift+Delete)
4. Hard refresh (Ctrl+F5)
5. Check browser console for CSS errors

### Wrong Colors Showing
- Using variables? `var(--px-accent)` not `#5ad1ff`
- Check `:root` section has your changes
- Ensure no inline styles overriding

### Layout Broken on Mobile
- Use `.px-grid` classes (auto-responsive)
- Test at 375px, 768px, 1024px widths
- Check `@media` queries in app.css

---

## 📊 Metrics

### Code Quality
- **Organized:** 16 clear sections with comments
- **Maintainable:** All colors in variables
- **Accessible:** WCAG AA contrast ratios
- **Performant:** GPU-accelerated animations

### File Sizes (Production)
- CSS: ~62 KB (12 KB gzipped)
- JS: ~36 KB (15 KB gzipped)
- Total: < 100 KB

### Browser Support
- ✅ Chrome 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+

---

## 🎓 Learning Path

### Beginner (Week 1)
1. Read **QUICK_REFERENCE.md** fully
2. Change one color and rebuild
3. Copy-paste a card component from **STYLE_GUIDE.md**
4. Experiment with button variants

### Intermediate (Week 2-3)
1. Read **STYLE_GUIDE.md** sections 1-8
2. Create a custom component
3. Try a theme variation from **COLOR_PALETTE.md**
4. Understand the grid system

### Advanced (Week 4+)
1. Study **CSS_REFACTOR_SUMMARY.md** structure
2. Add new animations
3. Create a complete page from scratch
4. Optimize for performance

---

## 🤝 Contributing

### Making Changes
1. **Always backup first:** `Copy-Item app.css app.css.backup`
2. **Test thoroughly:** Mobile, tablet, desktop
3. **Document changes:** Update relevant .md files
4. **Follow conventions:** Use `.px-*` naming

### Style Guide
- Keep comments clear and concise
- Use existing variables before creating new ones
- Test accessibility (contrast, keyboard nav)
- Optimize for performance (GPU transforms, will-change)

---

## 📞 Support

### Getting Help
1. Check **QUICK_REFERENCE.md** troubleshooting
2. Read **CSS_REFACTOR_SUMMARY.md** common issues
3. Review browser console errors
4. Compare with `app.css.backup`

### Reporting Issues
Include:
- What you changed
- Expected behavior
- Actual behavior
- Browser/device info
- Screenshots if visual

---

## 🎉 Quick Wins

Try these easy customizations to get started:

### 1. Make Buttons Bigger
```css
.px-btn {
  font-size: 0.75rem;  /* Was 0.65rem */
  padding: 0.7rem 1.2rem;  /* Was 0.55rem 0.95rem */
}
```

### 2. Rounder Corners Everywhere
```css
:root {
  --px-radius: 12px;  /* Was 6px */
}
```

### 3. Brighter Accent Color
```css
:root {
  --px-accent: #00d9ff;  /* Brighter cyan */
}
```

### 4. Larger Hero Title
```css
.px-hero-title {
  font-size: 4rem;  /* Was 3rem */
}
```

---

## 🏆 Best Practices

### Do's ✅
- Use CSS variables for colors
- Follow `.px-*` naming convention
- Keep `app.css.backup` updated
- Test on mobile first
- Document new components
- Use GPU-accelerated animations

### Don'ts ❌
- Don't use inline styles
- Don't hard-code hex colors
- Don't edit without backup
- Don't skip `npm run build`
- Don't ignore accessibility
- Don't use `left/top` for animations

---

## 🔮 Future Enhancements

Potential additions:
- Dark mode toggle
- Theme switcher (Red/Blue/Yellow)
- Animation speed controls
- Seasonal themes (winter, halloween)
- Print stylesheet improvements
- RTL language support

---

## 📦 Resources

### External Links
- [Tailwind CSS Docs](https://tailwindcss.com/docs)
- [VT323 Font](https://fonts.google.com/specimen/VT323)
- [CSS Variables Guide](https://developer.mozilla.org/en-US/docs/Web/CSS/--*)
- [WCAG Accessibility](https://www.w3.org/WAI/WCAG21/quickref/)

### Internal Files
- `app.css` - Main stylesheet
- `app.css.backup` - Safety backup
- All `.md` files in root directory

---

**Version:** 1.0  
**Last Updated:** October 2, 2025  
**Maintained by:** PokéStop Development Team

---

**Ready to start? Open QUICK_REFERENCE.md and begin customizing!** 🚀
