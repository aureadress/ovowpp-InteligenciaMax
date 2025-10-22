{{--
    Componente de Logo Dinâmico
    
    Uso:
    <x-theme-logo type="light" height="50px" />
    <x-theme-logo type="dark" />
    <x-theme-logo type="icon" width="32px" />
    
    Parâmetros:
    - type: 'light', 'dark' ou 'icon' (padrão: 'light')
    - height: altura do logo (padrão: configuração do tema)
    - width: largura do logo (padrão: configuração do tema)
    - class: classes CSS adicionais
    - alt: texto alternativo (padrão: nome do app)
--}}

@props([
    'type' => 'light',
    'height' => null,
    'width' => null,
    'class' => '',
    'alt' => null
])

@php
    $logoUrl = themeLogo($type);
    $logoHeight = $height ?? themeConfig('logo_height', '50px');
    $logoWidth = $width ?? themeConfig('logo_width', 'auto');
    $altText = $alt ?? config('app.name', 'Logo');
@endphp

<img 
    src="{{ $logoUrl }}" 
    alt="{{ $altText }}"
    class="theme-logo theme-logo--{{ $type }} {{ $class }}"
    style="height: {{ $logoHeight }}; width: {{ $logoWidth }}; object-fit: contain;"
    {{ $attributes }}
>
