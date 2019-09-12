@include('layouts.frontend.head')
<body class="cabinet">
<div id="app">
    @include('layouts.frontend.header')
    <div class="main">
        <div class="container">
            <div class="content-wrapper">
                @include('layouts.cabinet.sidebar')
                <div class="wrapper medium pl-50">
                    <div class="cabinet--data">
                        <h1>@yield('title')</h1>
                        <div class="cabinet--data_body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('layouts.frontend.footer')
</div>
<script src="{{ asset('js/cabinet.js') }}"></script>
</body>
</html>

