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

// Get colors from theme_settings using helper function
try {
    $adminColors = getThemeColors('admin');
    
    // Extract colors with fallbacks
    $primaryColor = $adminColors->primary ?? '#29B6F6';
    $secondaryColor = $adminColors->secondary ?? '#004AAD';
    $accentColor = $adminColors->accent ?? '#FF6600';
    $sidebarBg = $adminColors->sidebar_bg ?? '#1a1d29';
    $sidebarText = $adminColors->sidebar_text ?? '#ffffff';
    
} catch (Exception $e) {
    // Fallback colors if database error
    $primaryColor = '#29B6F6';
    $secondaryColor = '#004AAD';
    $accentColor = '#FF6600';
    $sidebarBg = '#1a1d29';
    $sidebarText = '#ffffff';
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

$secondaryRgb = implode(', ', sscanf($secondaryColor, "#%02x%02x%02x"));
$accentRgb = implode(', ', sscanf($accentColor, "#%02x%02x%02x"));

?>
:root {
    /* Admin Primary Colors */
    --primary-color: <?php echo $primaryColor; ?>;
    --primary-color-rgb: <?php echo $primaryRgb; ?>;
    --primary-light: <?php echo $primaryLight; ?>;
    --primary-dark: <?php echo $primaryDark; ?>;
    --base-color: <?php echo $primaryColor; ?>;
    
    /* Admin Secondary Colors */
    --secondary-color: <?php echo $secondaryColor; ?>;
    --secondary-color-rgb: <?php echo $secondaryRgb; ?>;
    
    /* Admin Accent Colors */
    --accent-color: <?php echo $accentColor; ?>;
    --accent-color-rgb: <?php echo $accentRgb; ?>;
    
    /* Admin Sidebar Colors */
    --sidebar-bg: <?php echo $sidebarBg; ?>;
    --sidebar-text: <?php echo $sidebarText; ?>;
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

/* Sidebar Styling */
.sidebar,
.navbar-wrapper__left,
.sidebar-menu {
    background-color: <?php echo $sidebarBg; ?> !important;
}

.sidebar .menu-item,
.sidebar .menu-link,
.sidebar-menu li a {
    color: <?php echo $sidebarText; ?> !important;
}

.sidebar .menu-item.active,
.sidebar .menu-item:hover {
    background-color: <?php echo $primaryColor; ?>;
    color: #ffffff !important;
}

.sidebar .menu-item.active .menu-link,
.sidebar .menu-item:hover .menu-link {
    color: #ffffff !important;
}

/* Secondary Color Applications */
.btn-secondary,
.bg-secondary,
.badge-secondary {
    background-color: <?php echo $secondaryColor; ?> !important;
    border-color: <?php echo $secondaryColor; ?> !important;
}

/* Accent Color Applications */
.btn-accent,
.bg-accent,
.badge-accent,
.text-accent {
    background-color: <?php echo $accentColor; ?> !important;
    color: #ffffff !important;
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
