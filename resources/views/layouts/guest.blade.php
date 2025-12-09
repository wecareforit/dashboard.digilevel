

<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
 
       <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles


  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="/assets/images/logos/favicon.png" />

  <!-- Core Css -->
  <link rel="stylesheet" href="/assets/css/styles.css" />

        <title>
            @isset($attributes['title'])
                {{ $attributes['title'] }} -
            @endisset
            {{ config('app.name', 'Laravel') }}
        </title>
  <!-- Jvectormap  -->
  <link rel="stylesheet" href="/assets/libs/jvectormap/jquery-jvectormap.css" />
</head>

<body>
 


        {{ $slot }}


  <div class="dark-transparent sidebartoggler"></div>
  <script src="/assets/js/vendor.min.js"></script>
  <!-- Import Js Files -->
  <script src="/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="/assets/js/theme/app.init.js"></script>
  <script src="/assets/js/theme/theme.js"></script>
  <script src="/assets/js/theme/app.min.js"></script>
  <script src="/assets/js/theme/sidebarmenu.js"></script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

  <!-- highlight.js (code view) -->
  <script src="/assets/js/highlights/highlight.min.js"></script>
  <script>
  hljs.initHighlightingOnLoad();


  document.querySelectorAll("pre.code-view > code").forEach((codeBlock) => {
    codeBlock.textContent = codeBlock.innerHTML;
  });
</script>
     @livewireScripts
  <script src="/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="/assets/libs/jvectormap/jquery-jvectormap.min.js"></script>
  <script src="/assets/js/jvectormap/jquery-jvectormap-us-aea-en.js"></script>
  <script src="/assets/js/dashboards/dashboard1.js"></script>
</body>

</html>

 