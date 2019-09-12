@extends('layouts.app')

@section('content')
    <div class="articles__box">
        @forelse($articles as $article)
            <div class="item">
                <a href="{{ route('post', $article->slug) }}" class="a-title">{{ $article->title }}</a>
                <div class="article_autor">
                    <div class="autor">
                        <img src="img/posts/articles.png" alt="">
                        <span>Анна Петрова</span>
                    </div>
                    <p class="date">26 июня 2019 12:45 <svg><use xlink:href="#time"></use></svg></p>
                </div>
                <img src="/storage/{{ $article->image }}" alt="{{ $article->title }}" title="{{ $article->title }}">
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
                    <div class="likes_box">
                        <button class="btn-like">
                            <svg><use xlink:href="#like"></use></svg>37
                        </button>
                        <button class="btn-like dislike">
                            <svg><use xlink:href="#like"></use></svg>8
                        </button>
                    </div>
                    <a href="{{ route('post', $article->slug) }}" class="btn-blue">Читать дальше</a>
                </div>
                <div class="article__tags">
                    <ul>
                        @forelse($article->atags as $tag)
                            <li><a href="{{route('tagsArticles', $tag->tag->slug)}}">{{$tag->tag->title}}</a></li>
                        @empty
                        @endforelse
                    </ul>
                </div>
            </div>
        @empty
        @endforelse
        <div class="pagination--data mb-30">
            <div class="pagination--info">
                <p>Показано: 1 - 30 (из 254)</p>
            </div>
            <ul class="pagination">
                <li><a href="" class="btn">Previos</a></li>
                <li><a href="" class="active">1</a></li>
                <li><a href="">2</a></li>
                <li><a href="">3</a></li>
                <li><a href="">4</a></li>
                <li><a href="" class="btn">Next</a></li>
            </ul>
        </div>
    </div>
@endsection
