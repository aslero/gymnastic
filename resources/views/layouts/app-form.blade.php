@include('layouts.frontend.head')
<body>
    <div id="app">
        @include('layouts.frontend.header')
        <div class="main">
            @yield('content')
        </div>
        @include('layouts.frontend.footer')
    </div>
@include('layouts.frontend.scripts')

