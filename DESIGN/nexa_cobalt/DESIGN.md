```markdown
# Design System Documentation: Digital Innovation Framework

## 1. Overview & Creative North Star
**Creative North Star: "The Caribbean Nocturne"**

This design system is built to position the agency not just as a service provider, but as a prestigious digital curator. To move beyond the "template" look of modern SaaS, we employ a philosophy of **Atmospheric Innovation.** We blend the deep, rhythmic density of a Caribbean night (Deep Navy) with the kinetic, neon energy of high-tech hubs (Electric Blue and Neon Purple).

The layout strategy favors **Intentional Asymmetry**. We break the rigid, centered grid by using oversized typography, overlapping glass layers, and "breathing room" (negative space) that feels expensive. The goal is a high-impact, editorial experience that feels as much like a luxury fashion magazine as it does a tech powerhouse.

---

## 2. Colors & Surface Philosophy
The color palette leverages deep tonal shifts to create a sense of infinite digital space.

### The "No-Line" Rule
**Borders are a failure of hierarchy.** In this system, 1px solid borders are prohibited for sectioning. Structural boundaries must be defined solely through background color shifts or tonal transitions. Use `surface-container-low` (#0b1228) sections against a `surface` (#070d1f) background to define change without clutter.

### Surface Hierarchy & Nesting
Treat the UI as physical layers of stacked material. Use the surface tiers to create "nested" depth:
*   **Base Layer:** `surface` (#070d1f)
*   **Secondary Sectioning:** `surface-container-low` (#0b1228)
*   **Interactive Containers/Cards:** `surface-container-high` (#131e3c)
*   **Elevated Overlays:** `surface-container-highest` (#182446)

### The "Glass & Gradient" Rule
To achieve the "Innovation Leader" aesthetic, main CTAs and Hero accents must utilize **Signature Textures**. 
*   **Gradients:** Instead of flat Electric Blue, use a linear gradient from `primary` (#7d98ff) to `primary_container` (#275dfb) at a 135-degree angle.
*   **Glassmorphism:** For floating navigation or modal overlays, use `surface_variant` (#182446) at 60% opacity with a `24px` backdrop blur. This creates a "frosted" effect that feels integrated into the environment.

---

## 3. Typography
We use a dual-font strategy to balance high-impact authority with technical precision.

*   **Display & Headline (Manrope):** This is our "Voice." It is bold, geometric, and unapologetic. Use `display-lg` (3.5rem) with tight letter-spacing (-0.02em) for hero headlines to mimic the "Nike" impact.
*   **Body & Labels (Inter):** This is our "Engine." It is clean, neutral, and highly legible. 
*   **Hierarchy as Identity:** Always maintain a stark contrast between sizes. A `display-md` headline should often be paired with a `label-md` uppercase sub-header with increased tracking (+0.1em) to create a premium, editorial feel.

---

## 4. Elevation & Depth
Depth in this system is achieved through **Tonal Layering**, not structural lines.

*   **The Layering Principle:** Place a `surface-container-lowest` (#000000) card on a `surface-container-low` (#0b1228) section to create a soft, natural inset. This mimics the way light behaves in a physical space.
*   **Ambient Shadows:** If a floating element (like a dropdown) requires a shadow, it must be "Ambient." Use a blur value of `32px` to `64px` with a 6% opacity of the `on_surface` color. Avoid pure black shadows; let the shadow carry a hint of the Deep Navy background.
*   **The "Ghost Border" Fallback:** If a container requires more definition (e.g., on an image-heavy background), use a **Ghost Border**. Apply the `outline_variant` (#3b476b) at **15% opacity**. It should be felt, not seen.

---

## 5. Components

### Buttons
*   **Primary:** Linear gradient (`primary` to `primary_container`). `0.25rem` (DEFAULT) or `full` roundedness. No border. Text is `on_primary` (#00185c).
*   **Secondary:** Ghost style. No background fill. `Ghost Border` (15% `outline_variant`) with `primary` text.
*   **Tertiary:** Bold `label-md` text in `tertiary` (#ddb7ff) with a chevron icon. Use for "Read More" links.

### Cards
Cards must never have dividers. Use `xl` (0.75rem) roundedness. 
*   **Design Pattern:** Use a `surface-container-high` background. Internal padding should be generous (min `2rem`). Separate content using the Spacing Scale (Vertical White Space) rather than lines.

### Input Fields
*   **Surface:** `surface_container` (#0f1832).
*   **Focus State:** Transition the background to `surface_bright` (#1c2a51) and add a `2px` glow using `primary` (#7d98ff) at 30% opacity. 
*   **Labels:** Use `label-md` in `on_surface_variant` (#9eaad3) positioned above the field.

### Chips & Badges
*   **Style:** Small, `full` roundedness.
*   **Visual:** Use `secondary_container` (#18263d) with `on_secondary_container` (#96a4c0) text for a subtle, tech-focused look.

---

## 6. Do's and Don'ts

### Do
*   **Do** use overlapping elements. Let a glassmorphic card partially obscure a high-impact image to create depth.
*   **Do** use "Electric Blue" (#7d98ff) sparingly as a high-contrast spotlight against the Deep Navy.
*   **Do** lean into large-scale imagery of Caribbean landscapes or abstract tech textures, treated with a dark blue overlay to maintain legibility.

### Don't
*   **Don't** use 1px solid dividers or high-contrast borders. It breaks the "No-Line" rule and cheapens the experience.
*   **Don't** use standard "Drop Shadows" (0, 4, 10, black). Use the Ambient Shadow guidelines.
*   **Don't** crowd the layout. If a section feels "busy," double the vertical white space. High-end design requires room to breathe.
*   **Don't** use pure white (#ffffff) for body text. Use `on_surface_variant` (#9eaad3) for secondary text to maintain the "Nocturne" atmosphere. Only use `on_primary_container` (#ffffff) for headlines or critical information.```