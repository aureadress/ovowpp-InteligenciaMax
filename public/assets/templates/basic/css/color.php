<?php
header("Content-Type:text/css");

// Carrega as configurações do Laravel (se disponível)
$configLoaded = false;
$themeConfig = [];

// Tenta carregar as configurações do Laravel
if (file_exists(__DIR__ . '/../../../../bootstrap/app.php')) {
    try {
        require_once __DIR__ . '/../../../../vendor/autoload.php';
        $app = require_once __DIR__ . '/../../../../bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
        
        // Carrega as configurações de tema
        $themeConfig = [
            'primary' => env('APP_PRIMARY_COLOR', '#29B6F6'),
            'secondary' => env('APP_SECONDARY_COLOR', '#004AAD'),
            'accent' => env('APP_ACCENT_COLOR', '#FF6600'),
            'success' => env('APP_SUCCESS_COLOR', '#28a745'),
            'warning' => env('APP_WARNING_COLOR', '#ffc107'),
            'danger' => env('APP_DANGER_COLOR', '#dc3545'),
            'info' => env('APP_INFO_COLOR', '#17a2b8'),
            'gradient_start' => env('APP_GRADIENT_START', '#29B6F6'),
            'gradient_end' => env('APP_GRADIENT_END', '#039BE5'),
        ];
        $configLoaded = true;
    } catch (Exception $e) {
        $configLoaded = false;
    }
}

// Função para validar cor hexadecimal
function checkHexColor($color)
{
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

// Define a cor primária
if (isset($_GET['color']) and $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
} elseif ($configLoaded && isset($themeConfig['primary'])) {
    $color = $themeConfig['primary'];
} else {
    $color = "#29B6F6";
}

if (!checkHexColor($color)) {
    $color = "#29B6F6";
}

// Converte Hex para HSL
function hexToHsl($hex)
{
    $hex   = str_replace('#', '', $hex);
    $red   = hexdec(substr($hex, 0, 2)) / 255;
    $green = hexdec(substr($hex, 2, 2)) / 255;
    $blue  = hexdec(substr($hex, 4, 2)) / 255;
    $cmin  = min($red, $green, $blue);
    $cmax  = max($red, $green, $blue);
    $delta = $cmax - $cmin;
    if ($delta == 0) {
        $hue = 0;
    } elseif ($cmax === $red) {
        $hue = (($green - $blue) / $delta);
    } elseif ($cmax === $green) {
        $hue = ($blue - $red) / $delta + 2;
    } else {
        $hue = ($red - $green) / $delta + 4;
    }
    $hue = round($hue * 60);
    if ($hue < 0) {
        $hue += 360;
    }
    $lightness  = (($cmax + $cmin) / 2);
    $saturation = $delta === 0 ? 0 : ($delta / (1 - abs(2 * $lightness - 1)));
    if ($saturation < 0) {
        $saturation += 1;
    }
    $lightness  = round($lightness * 100);
    $saturation = round($saturation * 100);
    $hsl['h']   = $hue;
    $hsl['s']   = $saturation;
    $hsl['l']   = $lightness;
    return $hsl;
}

// Gera variações de cor
function lightenColor($hex, $percent) {
    $hex = str_replace('#', '', $hex);
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    $r = min(255, $r + ($r * $percent / 100));
    $g = min(255, $g + ($g * $percent / 100));
    $b = min(255, $b + ($b * $percent / 100));
    
    return sprintf("#%02x%02x%02x", $r, $g, $b);
}

function darkenColor($hex, $percent) {
    $hex = str_replace('#', '', $hex);
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    $r = max(0, $r - ($r * $percent / 100));
    $g = max(0, $g - ($g * $percent / 100));
    $b = max(0, $b - ($b * $percent / 100));
    
    return sprintf("#%02x%02x%02x", $r, $g, $b);
}

$primaryLight = lightenColor($color, 30);
$primaryDark = darkenColor($color, 20);

// Define cores secundárias
$secondaryColor = $configLoaded ? $themeConfig['secondary'] : '#004AAD';
$accentColor = $configLoaded ? $themeConfig['accent'] : '#FF6600';
$successColor = $configLoaded ? $themeConfig['success'] : '#28a745';
$warningColor = $configLoaded ? $themeConfig['warning'] : '#ffc107';
$dangerColor = $configLoaded ? $themeConfig['danger'] : '#dc3545';
$infoColor = $configLoaded ? $themeConfig['info'] : '#17a2b8';
$gradientStart = $configLoaded ? $themeConfig['gradient_start'] : $color;
$gradientEnd = $configLoaded ? $themeConfig['gradient_end'] : $primaryDark;
?>

/* ============================================================================
   VARIÁVEIS CSS DO TEMA - InteligenciaMax
   Gerado dinamicamente a partir de config/theme.php e .env
   ============================================================================ */

:root {
    /* Cores Base (HSL) */
    --base-h: <?php echo hexToHsl($color)['h']; ?>;
    --base-s: <?php echo hexToHsl($color)['s']; ?>%;
    --base-l: <?php echo hexToHsl($color)['l']; ?>%;

    /* Cores Primárias */
    --primary-color: <?php echo $color; ?>;
    --primary-light: <?php echo $primaryLight; ?>;
    --primary-dark: <?php echo $primaryDark; ?>;
    --secondary-color: <?php echo $secondaryColor; ?>;
    --accent-color: <?php echo $accentColor; ?>;

    /* Cores de Status */
    --success-color: <?php echo $successColor; ?>;
    --warning-color: <?php echo $warningColor; ?>;
    --danger-color: <?php echo $dangerColor; ?>;
    --info-color: <?php echo $infoColor; ?>;

    /* Gradientes */
    --gradient-primary: linear-gradient(135deg, <?php echo $gradientStart; ?> 0%, <?php echo $gradientEnd; ?> 100%);
    --gradient-secondary: linear-gradient(135deg, <?php echo $secondaryColor; ?> 0%, <?php echo $primaryDark; ?> 100%);
    --gradient-accent: linear-gradient(135deg, <?php echo $accentColor; ?> 0%, <?php echo darkenColor($accentColor, 15); ?> 100%);

    /* Compatibilidade com código legado */
    --robot-primary: <?php echo $color; ?>;
    --robot-light: <?php echo $primaryLight; ?>;
    --robot-dark: <?php echo $primaryDark; ?>;
    --robot-gradient: var(--gradient-primary);
}

/* Aplicação das cores nos componentes */
.btn-primary,
.badge-primary,
.bg-primary {
    background-color: var(--primary-color) !important;
}

.btn-primary:hover,
.btn-primary:focus {
    background-color: var(--primary-dark) !important;
}

.text-primary {
    color: var(--primary-color) !important;
}

.border-primary {
    border-color: var(--primary-color) !important;
}

.btn-secondary,
.badge-secondary,
.bg-secondary {
    background-color: var(--secondary-color) !important;
}

.text-secondary {
    color: var(--secondary-color) !important;
}

.btn-success,
.badge-success,
.bg-success {
    background-color: var(--success-color) !important;
}

.btn-warning,
.badge-warning,
.bg-warning {
    background-color: var(--warning-color) !important;
}

.btn-danger,
.badge-danger,
.bg-danger {
    background-color: var(--danger-color) !important;
}

.btn-info,
.badge-info,
.bg-info {
    background-color: var(--info-color) !important;
}

.gradient-primary {
    background: var(--gradient-primary) !important;
}

.gradient-secondary {
    background: var(--gradient-secondary) !important;
}

/* Links */
a {
    color: var(--primary-color);
}

a:hover {
    color: var(--primary-dark);
}

/* Formulários */
.form-control:focus,
.form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(<?php echo hexdec(substr($color, 1, 2)); ?>, <?php echo hexdec(substr($color, 3, 2)); ?>, <?php echo hexdec(substr($color, 5, 2)); ?>, 0.25);
}

/* Navegação */
.nav-pills .nav-link.active,
.nav-pills .show > .nav-link {
    background-color: var(--primary-color);
}

/* Paginação */
.page-item.active .page-link {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.page-link {
    color: var(--primary-color);
}

.page-link:hover {
    color: var(--primary-dark);
}

/* Cards */
.card-header {
    background-color: var(--primary-color);
    color: white;
}

/* Alerts */
.alert-primary {
    background-color: var(--primary-light);
    border-color: var(--primary-color);
    color: var(--primary-dark);
}

/* Progress bars */
.progress-bar {
    background-color: var(--primary-color);
}

/* Spinners */
.spinner-border-primary {
    color: var(--primary-color);
}

/* Tables */
.table-primary {
    background-color: var(--primary-light);
}

/* Dropdown */
.dropdown-item.active,
.dropdown-item:active {
    background-color: var(--primary-color);
}