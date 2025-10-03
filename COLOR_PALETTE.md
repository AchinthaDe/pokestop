# Color Palette Reference

## Primary Colors

### Ocean Gradient Background
```
Surface Water:  #0f4b9a  rgb(15, 75, 154)   --px-bg-top
Mid Ocean:      #0a3570  rgb(10, 53, 112)   --px-bg-mid  
Deep Ocean:     #041a34  rgb(4, 26, 52)     --px-bg-deep
Seafloor:       #000000  rgb(0, 0, 0)       --px-bg-black
```

### Accent Colors
```
Primary Cyan:   #5ad1ff  rgb(90, 209, 255)  --px-accent
Soft Cyan:      #9fe6ff  rgb(159, 230, 255) --px-accent-soft
Game Boy Green: #b4f06a  rgb(180, 240, 106) --px-green
Retro Yellow:   #ffe9a3  rgb(255, 233, 163) --px-yellow
Danger Red:     #ff6363  rgb(255, 99, 99)   --px-danger
Dark Danger:    #aa0000  rgb(170, 0, 0)     --px-danger-dark
```

### Panel & Cards
```
Panel Base:     #0d233f  rgb(13, 35, 63)    --px-panel
Panel Alt:      #123357  rgb(18, 51, 87)    --px-panel-alt
Panel Dark:     #0a1a2e  rgb(10, 26, 46)    --px-panel-dark
```

### Borders
```
Standard:       #1f4d79  rgb(31, 77, 121)   --px-border
Light Edge:     #3c7db3  rgb(60, 125, 179)  --px-border-light
Shadow Edge:    #081525  rgb(8, 21, 37)     --px-border-dark
Accent Border:  #163e60  rgb(22, 62, 96)    --px-border-accent
```

### Text Colors
```
Primary Text:   #9fe6ff  rgb(159, 230, 255) --px-fg
Muted Text:     #85b4cd  rgb(133, 180, 205) --px-muted
Card Metadata:  #c5def0  rgb(197, 222, 240) --px-card-meta
```

---

## Color Usage Guide

### When to Use Each Color

#### --px-accent (Cyan #5ad1ff)
- Link hovers
- Active navigation items
- Button hover borders
- Input focus states
- Price highlights

#### --px-green (Game Boy Green #b4f06a)
- Section headings
- Card titles
- Success messages
- Positive actions

#### --px-danger (Red #ff6363)
- Error messages
- Delete buttons
- Warning states
- Required field indicators

#### --px-muted (Soft Blue #85b4cd)
- Secondary text
- Disabled states
- Placeholder text
- Footer text

---

## Theme Variations

### 🔴 Fire Red Theme (Pokémon Red)
```css
:root {
  --px-bg-top: #8a2730;
  --px-bg-mid: #61141a;
  --px-bg-deep: #2d0a0d;
  --px-accent: #ff8891;
  --px-accent-soft: #ffb3b8;
  --px-green: #ffcc66;
}
```

### 🟡 Electric Yellow Theme (Pokémon Yellow)
```css
:root {
  --px-bg-top: #e3b505;
  --px-bg-mid: #a67f00;
  --px-bg-deep: #5c4600;
  --px-accent: #fff066;
  --px-accent-soft: #fff9c4;
  --px-green: #7cb342;
}
```

### 🟣 Psychic Purple Theme (Pokémon Crystal)
```css
:root {
  --px-bg-top: #5e35b1;
  --px-bg-mid: #3e2466;
  --px-bg-deep: #1a0d2e;
  --px-accent: #ba68c8;
  --px-accent-soft: #e1bee7;
  --px-green: #81c784;
}
```

### ⚫ Dark Mode
```css
:root {
  --px-bg-top: #1a1a1a;
  --px-bg-mid: #0d0d0d;
  --px-bg-deep: #000000;
  --px-panel: #1e1e1e;
  --px-panel-alt: #2a2a2a;
}
```

### ⚪ Light Mode
```css
:root {
  --px-bg-top: #e3f2fd;
  --px-bg-mid: #bbdefb;
  --px-bg-deep: #90caf9;
  --px-panel: #ffffff;
  --px-panel-alt: #f5f5f5;
  --px-accent: #2196f3;
  --px-green: #4caf50;
  body { color: #212121; }
}
```

---

## Accessibility

### Contrast Ratios

All text/background combinations meet WCAG AA standards:

- Primary text (#9fe6ff) on dark background: **12:1** ✅
- Muted text (#85b4cd) on dark background: **8:1** ✅
- Accent (#5ad1ff) on panel (#0d233f): **9:1** ✅
- Green (#b4f06a) on panel (#0d233f): **11:1** ✅

### Color Blindness Safe

Current palette tested for:
- ✅ Deuteranopia (red-green, most common)
- ✅ Protanopia (red-green)
- ✅ Tritanopia (blue-yellow, rare)

**Tip:** Never rely on color alone. Use icons or text labels too.

---

## Design Tokens vs Hex Codes

### ✅ Best Practice (Use Variables)
```css
.my-button {
  color: var(--px-accent);
  border-color: var(--px-border);
}
```

### ❌ Avoid (Hard-coded Hex)
```css
.my-button {
  color: #5ad1ff;
  border-color: #1f4d79;
}
```

**Why?** Changing `--px-accent` updates everywhere instantly.

---

## Color Psychology

### Cyan/Aqua (Primary)
- **Meaning:** Water, calmness, technology
- **Emotion:** Trust, reliability, modern
- **Pokémon:** Lugia, Lapras, Squirtle

### Green (Secondary)
- **Meaning:** Success, growth, nature
- **Emotion:** Safety, harmony, positive
- **Pokémon:** Bulbasaur, Celebi, grass types
- **Heritage:** Original Game Boy Color screen

### Red (Danger)
- **Meaning:** Stop, error, urgent
- **Emotion:** Alert, attention, caution
- **Pokémon:** Charizard, fire types

---

## Export for Design Tools

### Figma / Sketch Variables
```
Primary:
  Cyan: #5ad1ff
  Green: #b4f06a
  Red: #ff6363

Background:
  Surface: #0f4b9a
  Mid: #0a3570
  Deep: #041a34

Neutrals:
  Text: #9fe6ff
  Muted: #85b4cd
  Border: #1f4d79
```

### Tailwind Config (if extending)
```js
module.exports = {
  theme: {
    extend: {
      colors: {
        'px-accent': '#5ad1ff',
        'px-green': '#b4f06a',
        'px-danger': '#ff6363',
      }
    }
  }
}
```

---

**Last Updated:** October 2, 2025
