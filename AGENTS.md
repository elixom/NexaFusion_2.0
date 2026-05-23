# agents.md — NexaFusion WordPress Theme

## Project Overview

This file governs all AI-assisted development on the **NexaFusion WordPress theme**.  The theme is built **from scratch** — no parent theme, but based primarily on the "twentytwentyfive" theme.

The built theme is saved in the "nexafusion-theme-3"
The themes are all stored in the folder "wp/wp-content/themes"

The design language is defined by the **"Caribbean Nocturne"** design system (see `DESIGN.md` and the `DESIGN/` folder for Stitch sample files). All decisions — layout, color, typography, component structure — must trace back to that system.

---

## Scope of AI Involvement

You are authorized to:

- Generate all PHP theme files (`functions.php`, template files, template parts, hooks)
- Write all CSS/SCSS following the design system tokens below
- Scaffold the WordPress theme directory structure
- Create block patterns, `theme.json`, and block template files (if FSE is used)
- Write JavaScript for interactive components (vanilla JS or minimal jQuery where WordPress requires it)
- Suggest and implement the `DESIGN/` Stitch samples as reusable template parts

You must **not**:

- Install or require plugins without explicit approval
- Deviate from the color palette, typography scale, or component rules defined below
- Use CSS `border` lines for sectioning (see the No-Line Rule)
- Use `box-shadow` values that reference pure black
- Use `#ffffff` for body or secondary text

---
## Project Directory Structure


## Theme Directory Structure
/
├── agents.md                  ← this file
├── DESIGN.md                  ← design system source of truth
├── DESIGN/                    ← Stitch sample files (reference for components)
├── wp/wp-content/themes/      ← wordpress themes folder

```
nexafusion-theme-3/
├── style.css                  ← Theme header + base reset
├── functions.php              ← Enqueue scripts/styles, register menus, theme support
├── index.php
├── front-page.php
├── header.php
├── footer.php
├── page.php
├── single.php
├── archive.php
├── 404.php
├── template-parts/
│   ├── hero.php
│   ├── cards.php
│   ├── cta.php
│   ├── nav.php
│   └── footer-widgets.php
├── assets/
│   ├── css/
│   │   ├── main.css
│   │   └── components/
│   │       ├── buttons.css
│   │       ├── cards.css
│   │       ├── forms.css
│   │       └── chips.css
│   ├── js/
│   │   └── main.js
│   └── fonts/
│       ├── manrope/
│       └── inter/
└── screenshot.png
```

---

## Design Tokens (CSS Custom Properties)

All styles must use these CSS variables. Never hardcode hex values directly in component CSS.

```css
:root {
  /* Surface hierarchy */
  --surface:                    #070d1f;
  --surface-container-lowest:   #000000;
  --surface-container-low:      #0b1228;
  --surface-container:          #0f1832;
  --surface-container-high:     #131e3c;
  --surface-container-highest:  #182446;
  --surface-bright:             #1c2a51;
  --surface-variant:            #182446;

  /* Brand colors */
  --primary:                    #7d98ff;
  --primary-container:          #275dfb;
  --on-primary:                 #00185c;
  --on-primary-container:       #ffffff;

  --secondary-container:        #18263d;
  --on-secondary-container:     #96a4c0;

  --tertiary:                   #ddb7ff;

  /* Text */
  --on-surface:                 #ffffff;
  --on-surface-variant:         #9eaad3;

  /* Outline */
  --outline-variant:            #3b476b;

  /* Gradients */
  --gradient-primary: linear-gradient(135deg, #7d98ff, #275dfb);

  /* Glassmorphism */
  --glass-bg:    rgba(24, 36, 70, 0.60); /* --surface-variant at 60% */
  --glass-blur:  24px;

  /* Ambient shadow */
  --shadow-ambient: 0 8px 48px 0 rgba(158, 170, 211, 0.06);

  /* Ghost border */
  --ghost-border: 1px solid rgba(59, 71, 107, 0.15);

  /* Roundedness */
  --radius-default: 0.25rem;
  --radius-xl:      0.75rem;
  --radius-full:    9999px;

  /* Typography */
  --font-display: 'Manrope', sans-serif;
  --font-body:    'Inter', sans-serif;

  --display-lg:   3.5rem;   /* Hero headlines */
  --display-md:   2.5rem;
  --label-md:     0.875rem;

  --tracking-tight:    -0.02em;
  --tracking-expanded: +0.10em;
}
```

---

## Design Rules (Enforced)

### The No-Line Rule
Sectioning **must** use background color shifts between surface tiers. No `1px solid` borders for layout boundaries. Violations must be refactored before committing.

### The Glass & Gradient Rule
- Primary CTAs and hero accents: use `var(--gradient-primary)` at 135°, never flat `var(--primary)`
- Floating nav and modal overlays: use `var(--glass-bg)` with `backdrop-filter: blur(var(--glass-blur))`

### Ambient Shadows Only
No `box-shadow: 0 4px 10px rgba(0,0,0,X)`. All shadows use `var(--shadow-ambient)` or a custom ambient value with `var(--on-surface-variant)` at ≤6% opacity, blur 32px–64px.

### Ghost Border Fallback
When a container needs definition on a busy background: `border: var(--ghost-border)`. It should be felt, not seen.

### Typography Contrast
Pair `display-md` headlines with `label-md` uppercase sub-headers at `letter-spacing: var(--tracking-expanded)`. Headlines use `var(--on-primary-container)` (`#ffffff`). Secondary/body text uses `var(--on-surface-variant)` (`#9eaad3`) — never `#ffffff`.

### Spacing & Breathing Room
Cards: minimum `2rem` internal padding. If a section feels busy, double its vertical whitespace. No dividers inside cards.

---

## Component Specifications

### Buttons

| Type      | Background                    | Border              | Text color          | Radius              |
|-----------|-------------------------------|---------------------|---------------------|---------------------|
| Primary   | `var(--gradient-primary)`     | none                | `var(--on-primary)` | `var(--radius-default)` or `var(--radius-full)` |
| Secondary | transparent                   | `var(--ghost-border)` | `var(--primary)` | matches primary     |
| Tertiary  | none                          | none                | `var(--tertiary)`   | none (text link + chevron) |

### Cards
- Background: `var(--surface-container-high)`
- Radius: `var(--radius-xl)`
- Padding: min `2rem`
- No internal dividers — use vertical spacing to separate content
- No `border` unless Ghost Border fallback is required

### Input Fields
- Background: `var(--surface-container)`
- Focus: background transitions to `var(--surface-bright)`, add `box-shadow: 0 0 0 2px rgba(125, 152, 255, 0.30)`
- Labels: `var(--label-md)` size, `var(--on-surface-variant)` color, positioned above the field

### Chips & Badges
- Background: `var(--secondary-container)`
- Text: `var(--on-secondary-container)`
- Radius: `var(--radius-full)`

---

## Stitch Design Samples

The `DESIGN/` folder contains Stitch-generated sample files that serve as the visual reference for key sections and components. When implementing any template part, you must:

1. Review the corresponding sample in `DESIGN/` before writing markup
2. Match the layout intent of the sample using the token system above
3. Note any divergence from the design system rules in a comment and flag for review

---

## WordPress-Specific Guidelines

- Use `wp_enqueue_style()` and `wp_enqueue_script()` — no hardcoded `<link>` or `<script>` tags in templates
- Register navigation menus in `functions.php`: at minimum `primary` and `footer`
- Use `get_template_part()` for all reusable sections
- All user-facing strings must be wrapped in `__()` or `_e()` with the `'nexafusion'` text domain
- Images: use `wp_get_attachment_image()` for WordPress-managed images; hero background images via CSS `background-image` with a dark blue overlay (`rgba(7, 13, 31, 0.65)`) to maintain legibility
- Avoid inline styles in PHP templates; add modifier classes and handle in CSS

---

## Commit Conventions

```
feat: add hero template part with glassmorphic nav
fix: correct ambient shadow on service cards
style: apply No-Line rule to testimonials section
refactor: extract button styles to components/buttons.css
```

---

## Out of Scope

The following are **not** part of this AI's remit on this project:

- Plugin development
- WooCommerce integration (unless added to scope)
- SEO configuration
- Hosting, server, or deployment configuration
- Content entry or media uploads