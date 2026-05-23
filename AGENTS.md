# agents.md — NexaFusion WordPress Theme

## Project Overview

This file governs all AI-assisted development on the **NexaFusion WordPress theme**. The theme is built **from scratch** — no parent theme — as a **Full Site Editing (FSE) block theme** inspired by the structure and quality standards of `twentytwentyfive` theme.

The built theme is saved in `nexafusion-theme-3`.
The themes are all stored in `wp/wp-content/themes`.

The design language is defined by the **Caribbean Nocturne** design system (see `DESIGN/nexa_cobalt/DESIGN.md` and the `DESIGN/` folder for Stitch sample files). All decisions — layout, color, typography, component structure — must trace back to that system.

---

## Scope of AI Involvement

You are authorized to:

- Generate and maintain FSE block theme files (`theme.json`, block templates, template parts, patterns, styles, and `functions.php`)
- Write all CSS following the design system tokens below
- Scaffold and maintain the WordPress block theme directory structure
- Create block patterns, `theme.json`, block template files, and reusable template parts
- Write JavaScript for interactive components only when required (vanilla JS or minimal jQuery where WordPress requires it)
- Suggest and implement the `DESIGN/` Stitch samples as reusable block patterns or template parts
- Read and use the WordPress theme documentation at https://developer.wordpress.org/themes/

You must **not**:

- Install or require plugins without explicit approval
- Deviate from the color palette, typography scale, or component rules defined below
- Use CSS `border` lines for sectioning (see the No-Line Rule)
- Use `box-shadow` values that reference pure black
- Use `#ffffff` for body or secondary text
- Inject CDN scripts/styles directly into template files or `wp_head`; use WordPress enqueue APIs and local theme CSS/JS

---
## Project Directory Structure


## FSE Block Theme Directory Structure
/
├── AGENTS.md                  ← this file
├── DESIGN/                    ← Stitch sample files and design-system documentation
├── wp/wp-content/themes/      ← WordPress themes folder

```
nexafusion-theme-3/
├── style.css                  ← Theme header + global styles/tokens
├── functions.php              ← Enqueue assets, register menus, theme support
├── index.php                  ← Required fallback file for block themes
├── theme.json                 ← Global settings, presets, template-part areas
├── templates/                 ← FSE block templates
│   ├── front-page.html
│   ├── index.html
│   ├── page.html
│   └── single.html
├── parts/                     ← FSE template parts
│   ├── header.html
│   └── footer.html
├── patterns/                  ← Optional PHP block patterns for reusable translated sections
├── assets/
│   ├── css/                   ← Optional split CSS loaded through enqueue APIs
│   ├── js/                    ← Optional local JavaScript loaded through enqueue APIs
│   └── fonts/                 ← Optional self-hosted fonts
└── screenshot.png             ← Theme screenshot when prepared for distribution
```

Classic PHP templates such as `front-page.php`, `header.php`, `footer.php`, `page.php`, `single.php`, `archive.php`, and `404.php` are **not required** for this theme unless the project explicitly moves away from FSE.

---

## Design Tokens (CSS Custom Properties)

All custom component CSS must use these CSS variables. Never hardcode hex values directly in component CSS except inside the token definitions themselves.

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

| Type      | Background                    | Border                | Text color          | Radius              |
|-----------|-------------------------------|-----------------------|---------------------|---------------------|
| Primary   | `var(--gradient-primary)`     | none                  | `var(--on-primary)` | `var(--radius-default)` or `var(--radius-full)` |
| Secondary | transparent                   | `var(--ghost-border)` | `var(--primary)`    | matches primary     |
| Tertiary  | none                          | none                  | `var(--tertiary)`   | none (text link + chevron) |

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

The `DESIGN/` folder contains Stitch-generated sample files that serve as the visual reference for key sections and components. When implementing any template part, template, or pattern, you must:

1. Review the corresponding sample in `DESIGN/` before writing markup
2. Match the layout intent of the sample using the token system above
3. Note any divergence from the design system rules in a comment and flag for review

---

## WordPress-Specific Guidelines

- Use `wp_enqueue_style()` and `wp_enqueue_script()` for local theme assets; do not hardcode `<link>` or `<script>` tags in templates
- Register navigation menus in `functions.php`: at minimum `primary` and `footer`
- Use FSE template parts (`parts/*.html`) and block patterns (`patterns/*.php`) for reusable sections
- Use the `'nexafusion'` text domain in PHP files and the `Text Domain: nexafusion` theme header
- Wrap user-facing PHP strings in `__()`, `esc_html__()`, `_e()`, or related escaping translation functions with the `'nexafusion'` text domain
- In `.html` block templates and parts, keep user-facing strings clear and extractable by WordPress i18n tooling; use PHP block patterns when a section needs explicit translation wrappers
- Images: use WordPress-managed images where possible. If a hero uses a CSS background image, pair it with a dark blue overlay (`rgba(7, 13, 31, 0.65)`) to maintain legibility
- Avoid inline styles in PHP templates; add modifier classes and handle in CSS. Serialized block styles in `.html` templates should be minimized and replaced with classes where practical

---

## Commit Conventions

```
feat: add FSE hero pattern with glassmorphic nav
fix: correct ambient shadow on service cards
style: apply No-Line rule to testimonials section
refactor: extract reusable block section styles
```

---

## Out of Scope

The following are **not** part of this AI's remit on this project:

- Plugin development
- WooCommerce integration (unless added to scope)
- SEO configuration
- Hosting, server, or deployment configuration
- Content entry or media uploads
