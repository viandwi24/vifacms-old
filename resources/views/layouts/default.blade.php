<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>@yield('title') | VIFA CMS - Simple CMS For You Blogging.</title>

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- OTHER CSS -->
  <style type="text/css">
    .btn-xs{padding:1px 5px;font-size:12px;line-height:1.5;border-radius:3px}
  </style>
  @stack('custom-css')
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper"> 
    @yield('content-header')
    @stack('content-main')
  </div>
  @yield('content-footer')

  <!-- JAVASCRIPT -->
  <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>
  <script src="{{ asset('assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>

  @stack('custom-js')
</body>
</html>
