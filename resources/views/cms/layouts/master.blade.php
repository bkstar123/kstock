<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        {{ config('app.name') }} | @yield('title')
    </title>
    <link href="{{ mix('/cms-assets/css/app.css') }}" rel="stylesheet">
    @stack('css')
    <script src="{{ mix('/cms-assets/js/app.js') }}"></script>
    <script src="{{ mix('/cms-assets/js/plugins.js') }}"></script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    @stack('scriptTop')
</head>
@guest
    <body class="hold-transition login-page">
        <!-- flashing message -->
        @include('bkstar123_flashing::flashing')
        @yield('content')
        @stack('scriptBottom')
    </body>
@else
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper" id="app">
            <!-- NavBar -->
            @include('cms.layouts.components.navbar')
            <!-- SideBar -->
            @include('cms.layouts.components.sidebar')
            <!-- Contents -->
            @include('cms.layouts.components.contents')
            <!-- Footer -->
            @include('cms.layouts.components.footer')
        </div><!-- ./wrapper -->
        <!-- flashing message -->
        @include('bkstar123_flashing::flashing')
        <script type="text/javascript">
            Echo.private('user-' + {{ auth()->user()->id }})
                .listen('.a.job.failed', (data) => {
                    $.notify('You may get incompleted outcome because KStock has failed to perform one of necessary jobs while proceeding the request', {
                        position: "right bottom",
                        className: "error",
                        clickToHide: true,
                        autoHide: false,
                    })
                });
            Echo.private('user-' + {{ auth()->user()->id }})
                .listen('.pull.financial.statement.completed', (data) => {
                    $.notify('KStock has successfully completed the request', {
                        position: "right bottom",
                        className: "success",
                        clickToHide: true,
                        autoHide: false,
                    })
                });
        </script>
        @stack('scriptBottom')
    </body>
@endguest
</html>
