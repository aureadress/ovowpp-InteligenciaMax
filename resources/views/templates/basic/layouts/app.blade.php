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
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom-animation.css') }}?v=1">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}?v=1">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">

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
