<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ gs()->siteName(__($pageTitle)) }}</title>

    <meta name="P-A-ID" content="{{ config('app.PUSHER_APP_KEY') }}">
    <meta name="P-CLUSTER" content="{{ config('app.PUSHER_APP_CLUSTER') }}">
    <meta name="APP-DOMAIN" content="{{ route('home') }}">

    @include('partials.seo')
    
    <!-- Favicon Dinâmico -->
    <link rel="shortcut icon" type="image/png" href="{{ siteFavicon() }}">
    <link rel="icon" type="image/png" href="{{ siteFavicon() }}">

    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">

    @stack('style-lib')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom-animation.css') }}?v={{ filemtime(public_path($activeTemplateTrue . 'css/custom-animation.css')) }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}?v={{ filemtime(public_path($activeTemplateTrue . 'css/custom.css')) }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}?v={{ filemtime(public_path($activeTemplateTrue . 'css/main.css')) }}">

    @stack('style')
    
    <!-- CSS Dinâmico do Tema -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ gs('base_color') }}&v={{ time() }}">
    
    <!-- CSS Customizado do Tema -->
    <link rel="stylesheet" href="{{ asset('assets/theme/theme-custom.css') }}?v={{ time() }}">
    
    <!-- Variáveis CSS Inline do Tema -->
    <style>
        :root {
            --theme-primary: {{ themeColor('primary', '#29B6F6') }};
            --theme-secondary: {{ themeColor('secondary', '#004AAD') }};
            --theme-accent: {{ themeColor('accent', '#FF6600') }};
            --theme-font-primary: {{ themeFont('primary') }};
            --theme-font-heading: {{ themeFont('heading') }};
            --theme-border-radius: {{ themeConfig('border_radius', '8px') }};
            --theme-logo-height: {{ themeConfig('logo_height', '50px') }};
        }
        
        body {
            font-family: var(--theme-font-primary);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--theme-font-heading);
        }
    </style>
    
    @php
        // Carregar cores do Frontend do theme_settings
        $frontendColors = getThemeColors('frontend');
    @endphp
    
    <!-- CSS Dinâmico do Frontend Público -->
    <style>
        :root {
            /* Botões */
            --frontend-btn-primary: {{ $frontendColors->buttons['primary'] ?? '#29B6F6' }};
            --frontend-btn-primary-hover: {{ $frontendColors->buttons['primary_hover'] ?? '#0288D1' }};
            --frontend-btn-secondary: {{ $frontendColors->buttons['secondary'] ?? '#6c757d' }};
            --frontend-btn-secondary-hover: {{ $frontendColors->buttons['secondary_hover'] ?? '#5a6268' }};
            --frontend-btn-text: {{ $frontendColors->buttons['text'] ?? '#ffffff' }};
            
            /* Header/Navbar */
            --frontend-header-bg: {{ $frontendColors->header['bg'] ?? '#ffffff' }};
            --frontend-header-text: {{ $frontendColors->header['text'] ?? '#212529' }};
            --frontend-header-link: {{ $frontendColors->header['link'] ?? '#29B6F6' }};
            --frontend-header-link-hover: {{ $frontendColors->header['link_hover'] ?? '#0288D1' }};
            
            /* Footer */
            --frontend-footer-bg: {{ $frontendColors->footer['bg'] ?? '#212529' }};
            --frontend-footer-text: {{ $frontendColors->footer['text'] ?? '#ffffff' }};
            --frontend-footer-link: {{ $frontendColors->footer['link'] ?? '#29B6F6' }};
            --frontend-footer-link-hover: {{ $frontendColors->footer['link_hover'] ?? '#0288D1' }};
            
            /* Background & Gradient */
            --frontend-bg-color: {{ $frontendColors->background['color'] ?? '#ffffff' }};
            --frontend-bg-gradient-start: {{ $frontendColors->background['gradient_start'] ?? '#29B6F6' }};
            --frontend-bg-gradient-end: {{ $frontendColors->background['gradient_end'] ?? '#0288D1' }};
            --frontend-use-gradient: {{ ($frontendColors->background['use_gradient'] ?? false) ? '1' : '0' }};
            
            /* Cards/Sections */
            --frontend-card-bg: {{ $frontendColors->cards['bg'] ?? '#ffffff' }};
            --frontend-card-border: {{ $frontendColors->cards['border'] ?? '#dee2e6' }};
            --frontend-card-shadow: {{ $frontendColors->cards['shadow'] ?? '#00000020' }};
            
            /* Text */
            --frontend-text-primary: {{ $frontendColors->text['primary'] ?? '#212529' }};
            --frontend-text-secondary: {{ $frontendColors->text['secondary'] ?? '#6c757d' }};
            --frontend-heading-color: {{ $frontendColors->text['heading'] ?? '#212529' }};
            
            /* Links */
            --frontend-link-color: {{ $frontendColors->links['color'] ?? '#29B6F6' }};
            --frontend-link-hover: {{ $frontendColors->links['hover'] ?? '#0288D1' }};
            
            /* Modals */
            --frontend-modal-bg: {{ $frontendColors->modal['bg'] ?? '#ffffff' }};
            --frontend-modal-header-bg: {{ $frontendColors->modal['header_bg'] ?? '#29B6F6' }};
            --frontend-modal-header-text: {{ $frontendColors->modal['header_text'] ?? '#ffffff' }};
            --frontend-modal-overlay: {{ $frontendColors->modal['overlay'] ?? '#00000080' }};
            
            /* Borders */
            --frontend-border-color: {{ $frontendColors->borders['color'] ?? '#dee2e6' }};
            --frontend-border-radius: {{ $frontendColors->borders['radius'] ?? '8' }}px;
            
            /* Hero Section */
            --frontend-hero-bg: {{ $frontendColors->hero['bg'] ?? '#29B6F6' }};
            --frontend-hero-text: {{ $frontendColors->hero['text'] ?? '#ffffff' }};
            --frontend-hero-overlay: {{ $frontendColors->hero['overlay'] ?? '#00000040' }};
            
            /* Features */
            --frontend-feature-bg: {{ $frontendColors->features['bg'] ?? '#f8f9fa' }};
            --frontend-feature-icon: {{ $frontendColors->features['icon'] ?? '#29B6F6' }};
            --frontend-feature-border: {{ $frontendColors->features['border'] ?? '#dee2e6' }};
        }
        
        /* ========== APLICAÇÃO DAS CORES NO FRONTEND ========== */
        
        /* Background do Site */
        body.frontend,
        main.frontend {
            background-color: var(--frontend-bg-color);
        }
        
        /* Gradiente de Fundo (se ativado) */
        body.frontend.use-gradient {
            background: linear-gradient(135deg, var(--frontend-bg-gradient-start) 0%, var(--frontend-bg-gradient-end) 100%);
        }
        
        /* Botões Primários */
        .btn-primary,
        .frontend .btn-primary {
            background-color: var(--frontend-btn-primary) !important;
            border-color: var(--frontend-btn-primary) !important;
            color: var(--frontend-btn-text) !important;
        }
        
        .btn-primary:hover,
        .frontend .btn-primary:hover {
            background-color: var(--frontend-btn-primary-hover) !important;
            border-color: var(--frontend-btn-primary-hover) !important;
        }
        
        /* Botões Secundários */
        .btn-secondary,
        .frontend .btn-secondary {
            background-color: var(--frontend-btn-secondary) !important;
            border-color: var(--frontend-btn-secondary) !important;
            color: #ffffff !important;
        }
        
        .btn-secondary:hover,
        .frontend .btn-secondary:hover {
            background-color: var(--frontend-btn-secondary-hover) !important;
            border-color: var(--frontend-btn-secondary-hover) !important;
        }
        
        /* Header/Navbar */
        .header,
        .navbar,
        .top-header {
            background-color: var(--frontend-header-bg) !important;
            color: var(--frontend-header-text) !important;
        }
        
        .header a,
        .navbar a,
        .navbar-nav .nav-link {
            color: var(--frontend-header-link) !important;
        }
        
        .header a:hover,
        .navbar a:hover,
        .navbar-nav .nav-link:hover {
            color: var(--frontend-header-link-hover) !important;
        }
        
        /* Footer */
        .footer,
        footer {
            background-color: var(--frontend-footer-bg) !important;
            color: var(--frontend-footer-text) !important;
        }
        
        .footer a,
        footer a {
            color: var(--frontend-footer-link) !important;
        }
        
        .footer a:hover,
        footer a:hover {
            color: var(--frontend-footer-link-hover) !important;
        }
        
        /* Cards */
        .card,
        .frontend .card {
            background-color: var(--frontend-card-bg) !important;
            border-color: var(--frontend-card-border) !important;
            box-shadow: 0 4px 8px var(--frontend-card-shadow);
            border-radius: var(--frontend-border-radius);
        }
        
        /* Textos */
        .frontend,
        .frontend p,
        .frontend .text-primary {
            color: var(--frontend-text-primary);
        }
        
        .frontend .text-secondary,
        .frontend small {
            color: var(--frontend-text-secondary);
        }
        
        .frontend h1,
        .frontend h2,
        .frontend h3,
        .frontend h4,
        .frontend h5,
        .frontend h6 {
            color: var(--frontend-heading-color);
        }
        
        /* Links */
        .frontend a {
            color: var(--frontend-link-color);
        }
        
        .frontend a:hover {
            color: var(--frontend-link-hover);
        }
        
        /* Modais */
        .modal-content {
            background-color: var(--frontend-modal-bg) !important;
            border-radius: var(--frontend-border-radius);
        }
        
        .modal-header {
            background-color: var(--frontend-modal-header-bg) !important;
            color: var(--frontend-modal-header-text) !important;
        }
        
        .modal-backdrop {
            background-color: var(--frontend-modal-overlay);
        }
        
        /* Borders Globais */
        .border,
        .frontend .border {
            border-color: var(--frontend-border-color) !important;
        }
        
        /* Hero Section */
        .hero-section,
        .banner-section,
        .hero {
            background-color: var(--frontend-hero-bg) !important;
            color: var(--frontend-hero-text) !important;
            position: relative;
        }
        
        .hero-section::before,
        .banner-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--frontend-hero-overlay);
            z-index: 1;
        }
        
        .hero-section > *,
        .banner-section > * {
            position: relative;
            z-index: 2;
        }
        
        /* Features/Services */
        .feature-item,
        .service-item,
        .features .card {
            background-color: var(--frontend-feature-bg) !important;
            border-color: var(--frontend-feature-border) !important;
        }
        
        .feature-item .icon,
        .service-item .icon,
        .feature-icon {
            color: var(--frontend-feature-icon) !important;
        }
    </style>
</head>
@php echo loadExtension('google-analytics') @endphp

<body>
    <div class="preloader">
        <span class="loader"></span>
    </div>
    <div class="body-overlay"></div>

    <div class="sidebar-overlay"></div>

    @yield('app-content')

    @include('Template::partials.cookie')

    <script src="{{ asset('assets/global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/wow.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>

    @stack('script-lib')

    <script src="{{ asset('assets/global/js/global.js') }}"></script>
    @php echo loadExtension('tawk-chat') @endphp

    @include('partials.notify')

    @if (gs('pn'))
        @include('partials.push_script')
    @endif

    @stack('script')

</body>
<script>
    (function($) {
        "use strict";

        $('.policy').on('click', function() {
            $.get('{{ route('cookie.accept') }}', function(response) {
                $('.cookies-card').addClass('d-none');
            });
        });

        // event when change lang
        $(".langSel").on("click", function() {
            let lang = $(this).data('value');
            window.location.href = "{{ route('home') }}/change/" + lang;
        });

        //show cookie card
        setTimeout(function() {
            $('.cookies-card').removeClass('hide');
        }, 2000);
    })(jQuery);
</script>
</body>

</html>
