<?php
/**
 * Dynamic CSS Color Generator - Admin Panel
 * Generates CSS with colors from database settings
 * Auto-updates when base_color changes
 */

// Load Laravel application
require __DIR__ . '/../../../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Set content type to CSS
header('Content-Type: text/css; charset=utf-8');
header('Cache-Control: public, max-age=3600'); // Cache for 1 hour

// Get color from settings
try {
    $general = app('App\Models\GeneralSetting')->first();
    $baseColor = $general->base_color ?? '29B6F6';
    
    // Ensure it's a valid hex color
    $baseColor = ltrim($baseColor, '#');
    if (!preg_match('/^[a-fA-F0-9]{6}$/', $baseColor)) {
        $baseColor = '29B6F6'; // Fallback
    }
    
    $primaryColor = '#' . $baseColor;
    
} catch (Exception $e) {
    // Fallback color if database error
    $primaryColor = '#29B6F6';
}

// Generate lighter and darker shades
function adjustBrightness($hex, $steps) {
    $hex = ltrim($hex, '#');
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    $r = max(0, min(255, $r + $steps));
    $g = max(0, min(255, $g + $steps));
    $b = max(0, min(255, $b + $steps));
    
    return sprintf("#%02x%02x%02x", $r, $g, $b);
}

$primaryLight = adjustBrightness($primaryColor, 40);
$primaryDark = adjustBrightness($primaryColor, -40);
$primaryRgb = implode(', ', sscanf($primaryColor, "#%02x%02x%02x"));

?>
:root {
    --primary-color: <?php echo $primaryColor; ?>;
    --primary-color-rgb: <?php echo $primaryRgb; ?>;
    --primary-light: <?php echo $primaryLight; ?>;
    --primary-dark: <?php echo $primaryDark; ?>;
    --base-color: <?php echo $primaryColor; ?>;
}

/* Primary color applications */
.btn-primary,
.bg-primary,
.badge-primary {
    background-color: <?php echo $primaryColor; ?> !important;
    border-color: <?php echo $primaryColor; ?> !important;
}

.btn-primary:hover,
.btn-primary:focus {
    background-color: <?php echo $primaryDark; ?> !important;
    border-color: <?php echo $primaryDark; ?> !important;
}

.text-primary {
    color: <?php echo $primaryColor; ?> !important;
}

.border-primary {
    border-color: <?php echo $primaryColor; ?> !important;
}

/* Links */
a {
    color: <?php echo $primaryColor; ?>;
}

a:hover {
    color: <?php echo $primaryDark; ?>;
}

/* Custom elements */
.custom-primary {
    color: <?php echo $primaryColor; ?>;
}

.custom-primary-bg {
    background-color: <?php echo $primaryColor; ?>;
}

/* Form controls focus */
.form-control:focus {
    border-color: <?php echo $primaryColor; ?>;
    box-shadow: 0 0 0 0.2rem rgba(<?php echo $primaryRgb; ?>, 0.25);
}

/* Sidebar active */
.sidebar .menu-item.active {
    background-color: <?php echo $primaryColor; ?>;
}

/* Pagination */
.pagination .page-item.active .page-link {
    background-color: <?php echo $primaryColor; ?>;
    border-color: <?php echo $primaryColor; ?>;
}

/* Progress bars */
.progress-bar {
    background-color: <?php echo $primaryColor; ?>;
}

/* Generated at: <?php echo date('Y-m-d H:i:s'); ?> */
