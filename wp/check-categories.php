/**
 * Diagnostic script to check categories and posts
 * Access this file directly in your browser: yoursite.com/check-categories.php
 */

require_once 'wp-load.php';

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>NexaFusion Category & Post Diagnostic</title>
    <style>
        body { font-family: system-ui, sans-serif; padding: 20px; background: #0a0f1f; color: #fff; }
        .section { background: #1a2642; padding: 20px; margin: 20px 0; border-radius: 8px; }
        h1 { color: #7d98ff; }
        h2 { color: #ddb7ff; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #3b476b; }
        th { background: #0f1832; color: #7d98ff; }
        .success { color: #50fa7b; }
        .error { color: #ff5555; }
        .warning { color: #f1fa8c; }
        code { background: #0f1832; padding: 2px 6px; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>NexaFusion Category & Post Diagnostic</h1>
    
    <div class="section">
        <h2>📂 All Categories</h2>
        <?php
        $categories = get_categories(['hide_empty' => false]);
        if (!empty($categories)) {
            echo '<table>';
            echo '<tr><th>ID</th><th>Name</th><th>Slug</th><th>Post Count</th></tr>';
            foreach ($categories as $cat) {
                $highlight = '';
                if ($cat->slug === 'services') $highlight = ' class="success"';
                if ($cat->slug === 'testimonials') $highlight = ' class="success"';
                
                echo "<tr{$highlight}>";
                echo "<td>{$cat->term_id}</td>";
                echo "<td>{$cat->name}</td>";
                echo "<td><code>{$cat->slug}</code></td>";
                echo "<td>{$cat->count}</td>";
                echo "</tr>";
            }
            echo '</table>';
        } else {
            echo '<p class="warning">⚠️ No categories found!</p>';
        }
        ?>
    </div>
    
    <div class="section">
        <h2>📝 All Published Posts</h2>
        <?php
        $posts = get_posts([
            'post_type' => 'post',
            'post_status' => 'publish',
            'numberposts' => 50,
            'orderby' => 'date',
            'order' => 'DESC'
        ]);
        
        if (!empty($posts)) {
            echo '<table>';
            echo '<tr><th>ID</th><th>Title</th><th>Categories</th><th>Date</th></tr>';
            foreach ($posts as $post) {
                $categories = get_the_category($post->ID);
                $cat_names = array_map(function($cat) { 
                    $highlight = '';
                    if ($cat->slug === 'services' || $cat->slug === 'testimonials') {
                        $highlight = ' class="success"';
                    }
                    return "<span{$highlight}>{$cat->name} ({$cat->slug})</span>";
                }, $categories);
                
                echo "<tr>";
                echo "<td>{$post->ID}</td>";
                echo "<td>{$post->post_title}</td>";
                echo "<td>" . implode(', ', $cat_names) . "</td>";
                echo "<td>" . get_the_date('Y-m-d H:i', $post) . "</td>";
                echo "</tr>";
            }
            echo '</table>';
        } else {
            echo '<p class="error">❌ No published posts found!</p>';
        }
        ?>
    </div>
    
    <div class="section">
        <h2>🔍 Services Category Check</h2>
        <?php
        $services_cat = get_category_by_slug('services');
        if ($services_cat) {
            echo '<p class="success">✅ Services category exists!</p>';
            echo '<ul>';
            echo "<li><strong>ID:</strong> {$services_cat->term_id}</li>";
            echo "<li><strong>Name:</strong> {$services_cat->name}</li>";
            echo "<li><strong>Slug:</strong> <code>{$services_cat->slug}</code></li>";
            echo "<li><strong>Post Count:</strong> {$services_cat->count}</li>";
            echo '</ul>';
            
            $services_posts = get_posts([
                'post_type' => 'post',
                'post_status' => 'publish',
                'category' => $services_cat->term_id,
                'numberposts' => -1
            ]);
            
            if (!empty($services_posts)) {
                echo '<p class="success">✅ Found ' . count($services_posts) . ' posts in Services category:</p>';
                echo '<ul>';
                foreach ($services_posts as $post) {
                    echo "<li>{$post->post_title}</li>";
                }
                echo '</ul>';
            } else {
                echo '<p class="warning">⚠️ No posts assigned to Services category!</p>';
                echo '<p>To fix: In WordPress admin, edit your service posts and assign them to the "Services" category.</p>';
            }
        } else {
            echo '<p class="error">❌ Services category does NOT exist!</p>';
            echo '<p><strong>To fix:</strong> In WordPress admin, go to Posts → Categories and create a new category:</p>';
            echo '<ul>';
            echo '<li><strong>Name:</strong> Services</li>';
            echo '<li><strong>Slug:</strong> services (all lowercase)</li>';
            echo '</ul>';
        }
        ?>
    </div>
    
    <div class="section">
        <h2>🔍 Testimonials Category Check</h2>
        <?php
        $testimonials_cat = get_category_by_slug('testimonials');
        if ($testimonials_cat) {
            echo '<p class="success">✅ Testimonials category exists!</p>';
            echo '<ul>';
            echo "<li><strong>ID:</strong> {$testimonials_cat->term_id}</li>";
            echo "<li><strong>Name:</strong> {$testimonials_cat->name}</li>";
            echo "<li><strong>Slug:</strong> <code>{$testimonials_cat->slug}</code></li>";
            echo "<li><strong>Post Count:</strong> {$testimonials_cat->count}</li>";
            echo '</ul>';
            
            $testimonials_posts = get_posts([
                'post_type' => 'post',
                'post_status' => 'publish',
                'category' => $testimonials_cat->term_id,
                'numberposts' => -1
            ]);
            
            if (!empty($testimonials_posts)) {
                echo '<p class="success">✅ Found ' . count($testimonials_posts) . ' posts in Testimonials category:</p>';
                echo '<ul>';
                foreach ($testimonials_posts as $post) {
                    echo "<li>{$post->post_title}</li>";
                }
                echo '</ul>';
            } else {
                echo '<p class="warning">⚠️ No posts assigned to Testimonials category!</p>';
                echo '<p>To fix: In WordPress admin, edit your testimonial posts and assign them to the "Testimonials" category.</p>';
            }
        } else {
            echo '<p class="error">❌ Testimonials category does NOT exist!</p>';
            echo '<p><strong>To fix:</strong> In WordPress admin, go to Posts → Categories and create a new category:</p>';
            echo '<ul>';
            echo '<li><strong>Name:</strong> Testimonials</li>';
            echo '<li><strong>Slug:</strong> testimonials (all lowercase)</li>';
            echo '</ul>';
        }
        ?>
    </div>
    
    <div class="section">
        <h2>ℹ️ Next Steps</h2>
        <ol>
            <li>Review the information above</li>
            <li>If categories don't exist, create them in WordPress admin (Posts → Categories)</li>
            <li>If posts aren't assigned to categories, edit the posts and assign them</li>
            <li>After making changes, refresh your Services and Testimonials pages</li>
        </ol>
    </div>
</body>
</html>
