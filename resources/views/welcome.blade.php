<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Magictours Puerto Vallarta</title>
    <link rel="shortcut icon" href="https://es.magictourspv.com/storage/icons/favicon.png" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="https://es.magictourspv.com/storage/icons/favicon.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="https://es.magictourspv.com/storage/icons/favicon.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="https://es.magictourspv.com/storage/icons/favicon.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="https://es.magictourspv.com/storage/icons/favicon.png">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- En tu <head> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

</head>
<body class="font-sans">
    <div id="app"></div>
    @vite('resources/js/app.js')

    <!--Start of Tawk.to Script-->
    {{-- <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/692e1ca40121eb197dd1b43f/1jbe1vp1p';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script> --}}
    <!--End of Tawk.to Script-->
</body>
</html>
