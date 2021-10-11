<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset(mix('/css/app.css')) }}" rel="stylesheet" />
    <script src="{{ asset(mix('/js/app.js')) }}" defer></script>

    <style>
      @font-face {
         font-family: 'Sarabun';
         src: url("{{ asset('fonts/Sarabun-Regular.ttf') }}");
         /* src: url("{{ asset('fonts/vendor/primevue/resources/themes/med/Sarabun-Regular.ttf') }}"); */
       }
       body {
         font-family: 'Sarabun';
         /* background-color: #FCFCFC; */
       }
    </style>
  </head>
  <body>
    @routes
    @inertia

    <script>
      const base_url = "{{ env('APP_URL') }}";
    </script>
  </body>
</html>