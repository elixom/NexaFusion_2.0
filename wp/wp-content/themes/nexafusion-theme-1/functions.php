<?php
/**
 * NexaFusion Functions and Definitions
 */

function nexafusion_setup() {
    // Add support for document title tag
    add_theme_support('title-tag');

    // Add support for featured images
    add_theme_support('post-thumbnails');

    // Add support for block templates
    add_theme_support('block-templates');

    // Editor Styles
    add_theme_support('editor-styles');
    add_editor_style('style.css');
}
add_action('after_setup_theme', 'nexafusion_setup');

function nexafusion_enqueue_assets() {
    // Enqueue Tailwind CDN
    wp_enqueue_script('tailwind-cdn', 'https://cdn.tailwindcss.com?plugins=forms', array(), null, false);

    // Enqueue Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;1,400&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap', array(), null);

    // Enqueue Theme Stylesheet (metadata only)
    wp_enqueue_style('nexafusion-style', get_stylesheet_uri(), array(), '1.0.0');

    // Inline Tailwind Config
    wp_add_inline_script('tailwind-cdn', "
        tailwind.config = {
            theme: {
                extend: {
                    'colors': {
                        'background': '#F5F5F5',
                        'surface': '#FFFFFF',
                        'primary': '#1A1A1A',
                        'secondary': '#6B7280',
                        'accent': '#9CA3AF',
                        'border': '#E5E7EB',
                    },
                    'fontFamily': {
                        'sans': ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        'serif': ['Playfair Display', 'ui-serif', 'Georgia', 'serif'],
                    }
                }
            }
        }
    ");
}
add_action('wp_enqueue_scripts', 'nexafusion_enqueue_assets');

// Custom CSS for Minimalism
function nexafusion_custom_styles() {
    echo "
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        body { background-color: #F5F5F5; color: #1A1A1A; }
    </style>
    ";
}
add_action('wp_head', 'nexafusion_custom_styles');
