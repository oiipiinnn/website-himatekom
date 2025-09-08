<?php
/**
 * Create .htaccess for uploads directory to fix 403 Forbidden
 * Run this on your hosting server
 */

echo "=== Creating .htaccess for uploads directory ===\n\n";

$uploadsPath = 'public/uploads';

// Create uploads directory if not exists
if (!is_dir($uploadsPath)) {
    mkdir($uploadsPath, 0755, true);
    echo "✅ Created uploads directory\n";
}

// Create .htaccess content
$htaccessContent = '# Allow access to uploaded files
<FilesMatch "\.(jpg|jpeg|png|gif|webp|svg|bmp|tiff|pdf|doc|docx)$">
    Require all granted
</FilesMatch>

# Prevent access to PHP files for security
<FilesMatch "\.php$">
    Require all denied
</FilesMatch>

# Enable expires headers for better caching
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpeg "access plus 1 month"
    ExpiresByType image/png "access plus 1 month"
    ExpiresByType image/gif "access plus 1 month"
    ExpiresByType image/webp "access plus 1 month"
    ExpiresByType image/svg+xml "access plus 1 month"
</IfModule>

# Enable gzip compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE image/svg+xml
</IfModule>

# Prevent directory browsing
Options -Indexes

# Set proper MIME types
<IfModule mod_mime.c>
    AddType image/webp .webp
    AddType image/svg+xml .svg
</IfModule>
';

// Write .htaccess file
$htaccessFile = $uploadsPath . '/.htaccess';
file_put_contents($htaccessFile, $htaccessContent);

echo "✅ Created .htaccess file: $htaccessFile\n";

// Set proper permissions
chmod($uploadsPath, 0755);
chmod($htaccessFile, 0644);

echo "✅ Set permissions: 755 for directory, 644 for .htaccess\n";

// Create subdirectories
$subdirs = [
    'galleries',
    'posts',
    'divisions/icons',
    'divisions/images', 
    'students/work_photos',
    'students/casual_photos',
    'students/validation_docs',
    'about'
];

foreach ($subdirs as $subdir) {
    $fullPath = $uploadsPath . '/' . $subdir;
    if (!is_dir($fullPath)) {
        mkdir($fullPath, 0755, true);
        echo "✅ Created: $fullPath\n";
    }
}

echo "\n=== Setup completed! ===\n";
echo "Now test accessing: https://yourdomain.com/uploads/test.jpg\n";
echo "If still getting 403, check your hosting panel for additional restrictions.\n";
?>