<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="icon" href="{{ asset('public/assets/images/pawprint.png') }}" type="image/png" sizes="16x16">
        <title>Lalubolu.in</title>
        
        <meta name="title" content="lalubalu.in">
        <meta name="description" content="create digital card with qr code and bar code for your dog within a minute">
        <meta name="keywords" content="download dog card, digital dog card, dog qr card, digital pet card, dog verification card, dog ownership card">
        <meta name="robots" content="index, follow">
        <meta name="language" content="English">
        <meta name="author" content="Arindam Roy">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="http://lalubalu.in/">
        <meta property="og:title" content="lalubalu.in">
        <meta property="og:description" content="create digital card with qr code and bar code for your dog within a minute">
        <meta property="og:image" content="https://lalubolu.in/public/assets/images/dog_green.png">

        <!-- Twitter -->
        <meta property="twitter:card" content="create digital card with qr code and bar code for your dog within a minute">
        <meta property="twitter:url" content="http://lalubalu.in/">
        <meta property="twitter:title" content="lalubalu.in">
        <meta property="twitter:description" content="create digital card with qr code and bar code for your dog within a minute">
        <meta property="twitter:image" content="https://lalubolu.in/public/assets/images/dog_green.png">
        
        <link rel="stylesheet" href="{{ asset('public/assets/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/assets/fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
    </head>
    <body>
        <noscript>
            <strong>We're sorry JavaScript enabled. Please enable it to continue.</strong>
        </noscript>
        <div id="app">
            <page-loader :is-Page-Loading="isPageLoadingActive"></page-loader>
            <app-index :is-nav-required="isHeaderNavShow"></app-index>
        </div>
    </body>
    <script src="{{ asset('public/assets/jquery.min.js') }}"></script>
    <script src="{{ asset('public/assets/popper.min.js') }}"></script>
    <script src="{{ asset('public/assets/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/app.js') }}"></script>
    <script src="{{ asset('public/js/custom.js') }}"></script>
</html>
