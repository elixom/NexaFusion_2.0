# NexaFusion Digital Agency WordPress Theme

A premium WordPress block theme featuring the "Caribbean Nocturne" design system - blending atmospheric innovation with high-tech precision.

## 📋 Theme Information

- **Theme Name:** NexaFusion Digital Agency
- **Version:** 1.0.0
- **Requires WordPress:** 6.2+
- **Requires PHP:** 7.4+
- **License:** GPL v2 or later
- **Text Domain:** wp-theme-nexafusion-digital-agency

## 🎨 Design Philosophy

This theme implements the **"Caribbean Nocturne"** design system with:

- **Atmospheric Innovation** - Deep navy backgrounds (#070d1f) with electric blue (#7d98ff) and neon purple (#ddb7ff) accents
- **Glassmorphism Effects** - Frosted navigation and overlay effects using backdrop-filter blur
- **Material Design 3** - Complete Material Design color system and typography scale
- **The "No-Line" Rule** - Uses surface color shifts instead of borders for visual hierarchy
- **Editorial Layouts** - Bento grids, asymmetric spacing, and high-impact typography

## 🚀 Features

### Built-in Sections
- ✅ Hero section with background imagery and gradient overlays
- ✅ Services bento grid layout (8-4, 4-4-8 column patterns)
- ✅ Portfolio gallery with staggered grid
- ✅ Call-to-action sections with blur effects
- ✅ Glassmorphic navigation bar
- ✅ 4-column footer with social links

### Technical Features
- ✅ Full Site Editing (FSE) support
- ✅ Block theme architecture
- ✅ Tailwind CSS via CDN (custom configured)
- ✅ Google Fonts: Manrope (headlines) + Inter (body)
- ✅ Material Symbols Outlined icons
- ✅ Responsive design (mobile-first)
- ✅ Dark theme optimized
- ✅ Custom color palette in theme.json

## 📁 Theme Structure

```
wp-theme-nexafusion-digital-agency/
├── style.css              # Theme header and base styles
├── functions.php          # Theme setup and enqueues
├── theme.json            # FSE configuration
├── index.php             # Required fallback file
├── README.md             # This file
├── parts/                # Template parts
│   ├── header.html       # Glassmorphic navigation
│   └── footer.html       # 4-column footer
└── templates/            # Page templates
    ├── index.html        # Blog archive
    ├── front-page.html   # Home page (hero, services, portfolio, CTA)
    ├── page.html         # Default page template
    └── single.html       # Single post template
```

## 🎨 Color System

The theme uses a complete Material Design 3 color palette:

### Primary Colors
- **Primary:** `#7d98ff` (Electric Blue)
- **Primary Container:** `#275dfb`
- **On Primary:** `#00185c`

### Surface Colors
- **Surface:** `#070d1f` (Deep Navy)
- **Surface Container Low:** `#0b1228`
- **Surface Container High:** `#131e3c`
- **Surface Container Highest:** `#182446`

### Accent Colors
- **Tertiary:** `#ddb7ff` (Neon Purple)
- **Secondary:** `#b9c7e4`

### Text Colors
- **On Surface:** `#dfe4ff`
- **On Surface Variant:** `#9eaad3`

## 🔤 Typography

- **Headlines:** Manrope (geometric, bold, 700-900 weight)
- **Body Text:** Inter (clean, readable, 400-700 weight)
- **Icons:** Material Symbols Outlined

### Typography Classes
- `.font-headline` - Manrope font
- `.font-body` - Inter font
- `.text-gradient` - Primary to tertiary gradient text

## 🛠️ Installation

1. **Upload Theme:**
   - Navigate to WordPress Admin > Appearance > Themes
   - Click "Add New" > "Upload Theme"
   - Upload the theme ZIP file or copy the folder to `wp-content/themes/`

2. **Activate Theme:**
   - Click "Activate" on the NexaFusion Digital Agency theme

3. **Configure Site:**
   - Go to Appearance > Editor to customize templates
   - Set your Site Title in Settings > General
   - Create pages for About, Services, Portfolio, Contact

## 📝 Usage

### Creating Pages

The theme works best with these key pages:

1. **Home Page** - Automatically uses `front-page.html` template
2. **About Page** - Use default `page.html` template, add custom content
3. **Services Page** - Use default `page.html` template
4. **Portfolio Page** - Use default `page.html` template  
5. **Contact Page** - Use default `page.html` template

### Customizing the Home Page

The home page (`templates/front-page.html`) includes:
- Hero section with background image
- Services bento grid
- Portfolio gallery
- CTA section

To edit: Go to Appearance > Editor > Templates > Front Page

### Navigation Menu

1. Go to Appearance > Editor > Navigation
2. Create menu items for: Services, Portfolio, Innovation, About, Contact
3. The glassmorphic navigation will automatically apply

### Using Custom Classes

The theme includes custom Tailwind-based utility classes:

```html
<!-- Glassmorphic Container -->
<div class="glass-nav">...</div>

<!-- Gradient Button -->
<button class="bg-gradient-to-br from-primary to-primary-container">...</button>

<!-- Material Icon -->
<span class="material-symbols-outlined">star</span>

<!-- Surface Layering -->
<div class="bg-surface-container-low">
  <div class="bg-surface-container-high">...</div>
</div>
```

## 🎯 Design Guidelines

### The "No-Line" Rule
❌ Don't use 1px borders for sections
✅ Use surface color shifts: `bg-surface` → `bg-surface-container-low`

### Glassmorphism
```css
background: rgba(24, 36, 70, 0.6);
backdrop-filter: blur(24px);
```

### Gradients
Always use the gradient utility:
```html
<div class="bg-gradient-to-br from-primary to-primary-container">
```

### Spacing
- Use generous padding: `p-12`, `py-32`
- Large gaps between sections
- "Breathing room" for high-end feel

## 🔧 Customization

### Changing Colors

Edit `functions.php` in the `nexafusion_digital_agency_inject_tailwind()` function to modify the Tailwind color palette.

### Adding Custom Fonts

Modify the Google Fonts URL in `functions.php`:
```php
wp_enqueue_style( 
    'nexafusion-digital-agency-fonts', 
    'https://fonts.googleapis.com/css2?family=YourFont...',
    ...
);
```

### Custom CSS

Add custom styles to `style.css` after line 100.

## 📱 Browser Support

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

**Note:** Glassmorphism effects require modern browsers with `backdrop-filter` support.

## 🐛 Troubleshooting

### Tailwind Classes Not Working
- Check that Tailwind CDN is loading in page source
- Clear browser cache and WordPress cache
- Ensure JavaScript is enabled

### Images Not Displaying
- Images use external Google-hosted URLs
- Replace with your own images or WordPress media library images
- Use Featured Images for blog posts

### Fonts Not Loading
- Check Google Fonts CDN connection
- Verify fonts are enqueued in `functions.php`
- Clear browser cache

## 📚 Resources

- [WordPress Block Theme Documentation](https://developer.wordpress.org/themes/block-themes/)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Material Design 3](https://m3.material.io/)
- [Material Symbols](https://fonts.google.com/icons)

## 🤝 Support

For theme support and customization:
- Check WordPress documentation
- Review theme files and comments
- Consult Tailwind CSS documentation for utility classes

## 📄 License

This theme is licensed under the GPL v2 or later.

---

**Created with Atmospheric Innovation** 🌌
