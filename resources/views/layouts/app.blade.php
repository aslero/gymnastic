@include('layouts.frontend.head')
<body>
    <div id="app">
        @include('layouts.frontend.header')
        <div class="main">
            <div class="container">
                <div class="content-wrapper">
                    <div class="wrapper pr-50">
                        @yield('content')
                    </div>
                    @include('layouts.frontend.sidebar')
                </div>
            </div>

        </div>
        @include('layouts.frontend.footer')
    </div>
@include('layouts.frontend.scripts')

