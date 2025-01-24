<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('path/to/fontawesome/css/all.min.css') }}">


    <!-- Bootbox.js depuis le CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.0/bootbox.min.js"></script>
    <!-- Inclure Bootstrap JS (à la fin du fichier body) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    @vite('resources/js/app.js')
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
    @include('admin.includes.navbar')
    @include('admin.includes.sidebar')
    @yield('content')
    </div>
    @yield('script')

   
    @vite('resources/js/app.js')
<!-- jQuery 3.6.4 (dernière version stable) -->



</body>
</html>
