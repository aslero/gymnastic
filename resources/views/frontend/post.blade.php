@extends('layouts.app')

@section('content')
    <div class="single content">
        <h1 class="a-title">{{ $article->title }}</h1>
        <div class="article_autor">
            <div class="autor">
                <img src="/storage/{{ $user->attributes->avatar }}" alt="{{ $user->attributes->fullname }}">
                <span>{{ $user->attributes->fullname }}</span>
            </div>
            <p class="date">{{ $article->created_at }} <svg><use xlink:href="#time"></use></svg></p>
        </div>
        <!--<ol class="content-links">
            <li><a href="">Lorem ipsum dolor sit amet, consectetur adipisicing elit</a></li>
            <li><a href="">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</a></li>
            <li><a href="">Ut enim ad minim veniam</a></li>
        </ol>-->
        <p>{!! $article->description !!}</p>
        @forelse($article->galleries as $row=>$gallery)
            <div class="a-point">
                {{ $row+1 }}

            </div>
            <h2>{{$gallery->title}}</h2>
            @if($gallery->image) <img src="/storage/{{$gallery->image}}" alt="@if(!empty($gallery->title)) {{$gallery->title}} @elseif(!empty($gallery->description)) {{$gallery->description}} @else {{ $article->title }} @endif"> @endif
            <p>{!! $gallery->description !!}</p>
        @empty

        @endforelse

        <div class="article_meta">
            <div class="box__comments">
                <div class="item-meta meta-btn comments">
                    <svg><use xlink:href="#chat"></use></svg>
                    <span>37</span>
                </div>
                <div class="item-meta favorite meta-btn">
                    <svg><use xlink:href="#star"></use></svg>
                    <span>3</span>
                </div>
                <div class="item-meta eye meta-btn">
                    <svg><use xlink:href="#eye"></use></svg>
                    <span>{{$article->view}}</span>
                </div>
            </div>
            <p class="author">Источник: @if(!empty($article->source)) <a href="$article->source" target="_blank">{{$article->source}}</a>@else <a href="/users/{$user->slug}">{{ $user->attributes->fullname }}</a> @endif</p>
            <div class="likes_box">
                <button class="btn-like">
                    <svg><use xlink:href="#like"></use></svg>37
                </button>
                <button class="btn-like dislike">
                    <svg><use xlink:href="#like"></use></svg>8
                </button>
            </div>
        </div>
        @if($tags)
            <div class="article__tags">
                <ul>
                    @forelse($tags as $tag)
                        <li><a href="/tags">{{$tag->title}}</a></li>
                        @empty
                    @endforelse
                </ul>
            </div>
        @endif
    </div>
    <div class="socila-share">
        <p>Поделиться:</p>
        <div class="social">
            <a href=""><img src="{{ url('/img/icons/vk.png') }}" alt=""></a>
            <a href=""><img src="{{ url('/img/icons/fb.png') }}" alt=""></a>
        </div>
    </div>
    <div class="comment--box">
        <div class="comment--header">
            <p>комментарии <span>(5)</span></p>
        </div>
        <div class="comment-form">
            <img src="{{ url('/img/users/list.jpg') }}" alt="" class="user">
            <div class="form--data">
                <textarea name="" id="" cols="30" rows="5" placeholder="Введите текст комментария"></textarea>
                <button class="btn-blue">Отправить</button>
            </div>
        </div>
        <ul class="comment--wrapper">
            <li class="comment--item">
                <div class="user--info">
                    <img src="{{ url('/img/users/list.jpg') }}" alt="" class="user">
                    <div class="raiting"><svg><use xlink:href="#star"></use></svg> 10 283</div>
                </div>
                <div class="comment--user">
                    <div class="user--comment--header">
                        <a href="" class="user--link">Алена Смирнова</a>
                        <p class="date">26 июня 2019 12:45 <svg><use xlink:href="#time"></use></svg></p>
                    </div>
                    <div class="comment--body">
                        Поддерживаю! Это интересней всякой джигурды облепившей Фишки в последнее время.
                    </div>
                    <div class="comment--footer">
                        <div class="btn--action">
                            <button class="btn-link">Ответить</button>
                            <button class="btn-link">Ссылка</button>
                            <button class="btn-link">Пожаловаться</button>
                            <button class="btn-link">Поделиться</button>
                        </div>
                        <div class="likes_box">
                            <button class="btn-like">
                                <svg><use xlink:href="#like"></use></svg>37
                            </button>
                            <button class="btn-like dislike">
                                <svg><use xlink:href="#like"></use></svg>8
                            </button>
                        </div>
                    </div>
                </div>
                <ul class="comment--wrapper__sub">
                    <li class="comment--item">
                        <div class="user--info">
                            <img src="{{ url('/img/users/list.jpg') }}" alt="" class="user">
                            <div class="raiting"><svg><use xlink:href="#star"></use></svg> 10 283</div>
                        </div>
                        <div class="comment--user">
                            <div class="user--comment--header">
                                <a href="" class="user--link">Алена Смирнова</a>
                                <p class="date">26 июня 2019 12:45 <svg><use xlink:href="#time"></use></svg></p>
                            </div>
                            <div class="comment--body">
                                Поддерживаю! Это интересней всякой джигурды облепившей Фишки в последнее время.
                                <img src="img/posts/single.jpg" alt="">
                            </div>
                            <div class="comment--footer">
                                <div class="btn--action">
                                    <button class="btn-link">Ответить</button>
                                    <button class="btn-link">Ссылка</button>
                                    <button class="btn-link">Пожаловаться</button>
                                    <button class="btn-link">Поделиться</button>
                                </div>
                                <div class="likes_box">
                                    <button class="btn-like">
                                        <svg><use xlink:href="#like"></use></svg>37
                                    </button>
                                    <button class="btn-like dislike">
                                        <svg><use xlink:href="#like"></use></svg>8
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
@endsection
