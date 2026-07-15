@if ($page && filled($page->body))
    <div class="home-main-content page-rich-content mar-b-30">
        <div class="container">
            {!! $page->body !!}
        </div>
    </div>
@endif
