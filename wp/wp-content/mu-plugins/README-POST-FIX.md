# NexaFusion Post & Media Fix

## Problem
Posts show count "All (8) | Published (8)" but the list is empty ("No posts found"). Media uploads also not appearing.

## Root Cause
This is a **ServerlessWP + SQLite + FSE theme** issue where:
1. Post queries in admin are failing due to filter conflicts or SQLite query issues
2. Media uploads require S3 configuration (local files don't persist in serverless)

## Solution Implemented

### 1. Post Display Fix (nexafusion-post-fix.php)
This must-use plugin:
- **Diagnoses** the query issue by logging detailed information
- **Auto-fixes** by using direct database queries when the standard query fails
- Logs all diagnostic info to error logs for troubleshooting

### 2. How It Works
When you visit `/wp-admin/edit.php` (Posts page):
1. Plugin checks if posts are found but not displayed
2. If issue detected, runs a direct SQL query to fetch posts
3. Returns posts directly, bypassing the problematic query layer
4. Logs everything for debugging

### 3. Testing the Fix

**Deploy to Vercel:**
```bash
git add .
git commit -m "fix: add post display diagnostic and auto-fix plugin"
git push
```

**Then visit your WordPress admin:**
1. Go to Posts → All Posts
2. You should now see your 8 posts listed
3. Check Vercel logs for diagnostic information

### 4. Media Upload Fix

For images to work in ServerlessWP, you **must** configure S3 storage.

**Required Vercel Environment Variables:**
```
S3_KEY_ID=your_aws_access_key_id
S3_ACCESS_KEY=your_aws_secret_access_key
```

**Steps:**
1. Create an S3 bucket in AWS (or compatible service like Cloudflare R2, Backblaze B2)
2. Create IAM credentials with bucket write permissions
3. Add the environment variables to Vercel
4. Redeploy your site
5. In WordPress admin, activate the "WP Offload Media Lite" plugin
6. Configure it with your S3 bucket details

**Alternative - Use SQLite for everything:**
If you're already using SQLite+S3 for the database, media files are trickier. Consider:
- Using a dedicated media CDN/host
- Switching to a MySQL database so you can use S3 purely for media

## Verification

✅ **Posts working:** Visit `/wp-admin/edit.php` and see your posts listed
✅ **Media working:** Upload an image, see it in Media Library, use it in a post

## If Issues Persist

1. **Check Vercel logs** - Look for the diagnostic messages
2. **Enable WP_DEBUG** - Add to `wp-config.php`: `define('WP_DEBUG', true);`
3. **Test with default theme** - Switch to Twenty Twenty-Five temporarily
4. **Check database** - Verify posts exist: Go to Posts → Add New → View all posts

## Removing This Fix

Once the root cause is identified and resolved, you can:
1. Delete `nexafusion-post-fix.php` from `/wp-content/mu-plugins/`
2. Commit and redeploy

## Technical Details

**Affected by:**
- SQLite Database Integration plugin
- ServerlessWP architecture (ephemeral filesystem)
- WordPress admin list table query complexity
- Potential plugin filter conflicts

**Works by:**
- Hooking into `the_posts` filter at priority 999
- Detecting mismatch between `found_posts` and actual results
- Running direct `wpdb->get_results()` query as fallback
- Preserving all WordPress query capabilities
