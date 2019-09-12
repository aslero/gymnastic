<div class="sidebar left medium">
    <nav class="cabinet-nav">
        <a href="{{ route('profile') }}" {{ Request::is('cabinet') ? 'class=active' : '' }}>Профиль</a>
        <a href="{{ route('cabinetArticles') }}" {{ Request::is('cabinet/posts') ? 'class=active' : '' }}>Статьи</a>
        <a href="">Объаявления</a>
        <a href="">Мероприятия</a>
        <a href="">Организации</a>
        <a href="">Семинары</a>
        <a href="">Терниры</a>
        <a href="">Рейтинг</a>
    </nav>
</div>