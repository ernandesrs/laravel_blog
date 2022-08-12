<div class="article">
    <img class="img img-fluid" src="{{ m_article_cover_thumb($article, $featured ?? false ? 'medium' : 'medium') }}"
        alt="{{ $article->title }}">

    <div class="title-and-desc">
        <h2 class="title">
            <a href="{{ route('front.article', ['slug' => $article->slugs()->first()->slug(app()->getLocale())]) }}"
                title="{{ $article->title }}">
                {{ $article->title }}
            </a>
        </h2>
        <p class="description">
            {{ substr($article->description, 0, 125) }}...
        </p>
    </div>
</div>

<div class="info">
    <div class="d-flex">
        <span class="mr-2">
            {{ icon_elem('userFill') }} <span>{{ substr($article->author()->first()->name, 0, 8) }}...</span>
        </span>
        <span class="ml-2">
            {{ icon_elem('calendarCheckFill') }}
            <span>{{ date('d/m/Y H:i:s', strtotime($article->published_at)) }}</span>
        </span>
    </div>

    <div class="d-flex">
        <span class="mr-2 categories">
            {{ icon_elem('folderFill') }}
            @php
                $articleCategories = $article->categories();
                $total = $articleCategories->count();
                $count = 0;
            @endphp
            @foreach ($article->categories()->get() as $category)
                @php
                    $count++;
                @endphp
                <a href="{{ route('front.category', ['slug' => $category->slugs()->first()->slug(app()->getLocale())]) }}"
                    title="Ver todos os artigos em {{ $category->title }}">{{ $category->title }}</a>{{ $count < $total ? ',' : null }}
            @endforeach
        </span>
    </div>
</div>
