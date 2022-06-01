<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>




    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/navbar.css')}}">
    <link rel="stylesheet" href="{{asset('css/paralax.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">


    <link rel="stylesheet" href="{{asset('css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/stylemodal.css')}}">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">



    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!--Javascript Carousel-->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>
    <script type="text/javascript">
        window.Laravel = {
            csrfToken: "{{ csrf_token() }}",
            jsPermissions: {!! auth()->check() ? auth()->user()->jsPermissions() :  "{}" !!}
        }

    </script>
 <!-- Styles -->
 <link href="{{ asset('css/home.css') }}" rel="stylesheet">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">



    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>




</head>

<body>
    <div  id="app">


    </div>


</body>




<script>
    var $parallaxElement = $('.parallax-bg');
    var elementHeight = $parallaxElement.outerHeight();

    function parallax() {

        var scrollPos = $(window).scrollTop();
        var transformValue = scrollPos / 40;
        var opacityValue = 1 - (scrollPos / 2000);
        var blurValue = Math.min(scrollPos / 100, 3);
        /*
             if (scrollPos < elementHeight) {

               $parallaxElement.css({
                 'transform': 'translate3d(0, -' + transformValue + '%, 0)',
                 'opacity': opacityValue,
                 '-webkit-filter': 'blur(' + blurValue + 'px)'
               });

             }

             */

    }

    $(window).scroll(function () {
        parallax();


    });

    $(window).scroll(function () {
        var scroll = $(window).scrollTop();

        if (scroll > 500) {
            $('.menu').css('background-color', 'white');
            $('.nav-item a').css('color', '#333');
        } else {
            $('.menu').css('background-color', '');
            $('.nav-item a').css('color', '');
        }
    });


</script>

</html>
