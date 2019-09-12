<header>
    <div class="top">
        <div class="container">
            <div class="box__container">
                <nav>
                    <a href="{{ route('posts') }}" title="Посты">Посты</a>
                    <a href="">Лайки</a>
                    <a href="">Комментарии</a>
                    <a href="">Подписки</a>
                    <a href="">Избранное</a>
                </nav>
                <div class="user__action">
                    <a href="" class="icon settings">
                        <svg><use xlink:href="#settings"></use></svg>
                    </a>
                    <a href="" class="icon logaut">
                        <svg><use xlink:href="#logaut"></use></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="center">
        <div class="container">
            <div class="logo__box">
                <a href="/" class="logo"></a>
                <form action="" class="search">
                    <input type="text" placeholder="Фраза или тег для поиска">
                    <svg><use xlink:href="#search"></use></svg>
                </form>
            </div>
            <div class="user__data">
                @if (Auth::guest())
                    <div class="btn-group__user">
                        <a href="/login" class="auth">Войти</a>
                        <a href="/register" class="register btn-default">Регистрация</a>
                    </div>
                @else

                    <div class="user--data-auth">
                        <div class="user__avatar">
                            <div class="user__info">
                                <p class="name">{{ Auth::user()->attributes->fullname }}</p>
                                <p class="raiting">
                                    <svg><use xlink:href="#star"></use></svg>
                                    <span>{{ Auth::user()->attributes->raiting }}</span>
                                </p>
                            </div>
                            <img src="/storage/{{ Auth::user()->attributes->avatar }}" alt="{{ Auth::user()->attributes->fullname }}">
                        </div>
                        <div class="user--menu">
                            <nav>
                                <a href="{{route('profile')}}">Личный кабинет</a>
                                <form id="logout-form" class="exit-form" action="{{ route('logout') }}" method="POST">
                                    {{ csrf_field() }}
                                    <button type="submit" class="logaut">Выход</button>
                                </form>

                            </nav>
                        </div>
                    </div>

                    <a href="{{ route('addArticle') }}" class="btn-add">
                        <svg><use xlink:href="#plus"></use></svg>
                    </a>
                @endif


            </div>
        </div>
    </div>
    <div class="bottom">
        <div class="container">
            <nav>
                <a href="">турниры</a>
                <a href="">рейтинг</a>
                <a href="">организации</a>
                <a href="">объявления</a>
                <a href="">календарь</a>
                <a href="">музыка</a>
            </nav>
        </div>
    </div>
</header>