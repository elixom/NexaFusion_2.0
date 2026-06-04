<?php
/**
 * Setup script to create Services and Testimonials categories
 * Access this file once in your browser: yoursite.com/setup-categories.php
 */

require_once 'wp-load.php';

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>NexaFusion Category Setup</title>
    <style>
        body { font-family: system-ui, sans-serif; padding: 40px; background: #0a0f1f; color: #fff; max-width: 800px; margin: 0 auto; }
        h1 { color: #7d98ff; }
        .success { background: #1a4d2e; border-left: 4px solid #50fa7b; padding: 15px; margin: 20px 0; }
        .error { background: #4d1a1a; border-left: 4px solid #ff5555; padding: 15px; margin: 20px 0; }
        .info { background: #1a2642; border-left: 4px solid: #7d98ff; padding: 15px; margin: 20px 0; }
        code { background: #0f1832; padding: 2px 6px; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>🚀 NexaFusion Category Setup</h1>
    
    <?php
    // Create Services category
    $services_created = false;
    $services_cat = get_category_by_slug('services');
    
    if (!$services_cat) {
        $result = wp_insert_term(
            'Services',
            'category',
            array(
                'slug' => 'services',
                'description' => 'Agency services and offerings'
            )
        );
        
        if (!is_wp_error($result)) {
            $services_created = true;
            $services_cat = get_category($result['term_id']);
            echo '<div class="success">✅ <strong>Services category created successfully!</strong><br>';
            echo 'ID: ' . $services_cat->term_id . ' | Slug: <code>services</code></div>';
        } else {
            echo '<div class="error">❌ Error creating Services category: ' . $result->get_error_message() . '</div>';
        }
    } else {
        echo '<div class="info">ℹ️ Services category already exists<br>';
        echo 'ID: ' . $services_cat->term_id . ' | Slug: <code>' . $services_cat->slug . '</code></div>';
    }
    
    // Create Testimonials category
    $testimonials_created = false;
    $testimonials_cat = get_category_by_slug('testimonials');
    
    if (!$testimonials_cat) {
        $result = wp_insert_term(
            'Testimonials',
            'category',
            array(
                'slug' => 'testimonials',
                'description' => 'Client testimonials and reviews'
            )
        );
        
        if (!is_wp_error($result)) {
            $testimonials_created = true;
            $testimonials_cat = get_category($result['term_id']);
            echo '<div class="success">✅ <strong>Testimonials category created successfully!</strong><br>';
            echo 'ID: ' . $testimonials_cat->term_id . ' | Slug: <code>testimonials</code></div>';
        } else {
            echo '<div class="error">❌ Error creating Testimonials category: ' . $result->get_error_message() . '</div>';
        }
    } else {
        echo '<div class="info">ℹ️ Testimonials category already exists<br>';
        echo 'ID: ' . $testimonials_cat->term_id . ' | Slug: <code>' . $testimonials_cat->slug . '</code></div>';
    }
    
    // Check for posts
    $all_posts = get_posts(array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'numberposts' => -1
    ));
    
    echo '<h2>📝 Published Posts</h2>';
    if (!empty($all_posts)) {
        echo '<div class="success">Found ' . count($all_posts) . ' published posts:</div>';
        echo '<ul>';
        foreach ($all_posts as $post) {
            $cats = get_the_category($post->ID);
            $cat_names = array_map(function($c) { return $c->name; }, $cats);
            echo '<li><strong>' . esc_html($post->post_title) . '</strong>';
            if (!empty($cat_names)) {
                echo ' - Categories: ' . implode(', ', $cat_names);
            } else {
                echo ' - <span style="color: #f1fa8c;">⚠️ No categories assigned</span>';
            }
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo '<div class="error">❌ No published posts found. Create some posts in WordPress admin!</div>';
    }
    
    echo '<h2>✅ Next Steps</h2>';
    echo '<ol>';
    echo '<li>The Services and Testimonials categories are now set up</li>';
    echo '<li>Go to WordPress Admin → Posts → All Posts</li>';
    echo '<li>Edit each post and assign it to the appropriate category (Services or Testimonials)</li>';
    echo '<li>Visit your Services page to see the posts appear</li>';
    echo '<li><strong>Delete this file (setup-categories.php) when done for security</strong></li>';
    echo '</ol>';
    ?>
</body>
</html>
