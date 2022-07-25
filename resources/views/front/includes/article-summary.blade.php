<div class="article">
    <img class="img img-fluid" src="{{ $article->image }}" alt="{{ $article->title }}">

    <div class="title-and-desc">
        <h2 class="title">
            {{ $article->title }}
        </h2>
        <p class="description">
            {{ substr($article->description, 0, 125) }}...
        </p>
    </div>
</div>

<div class="info">
    <div class="d-flex">
        <span class="mr-2">
            {{ icon_elem('userFill') }} <span>{{ substr($article->author->name, 0, 8) }}...</span>
        </span>
        <span class="ml-auto ml-lg-2">
            {{ icon_elem('calendarCheckFill') }}
            <span>{{ date('d/m/Y', strtotime($article->created_at)) }}</span>
        </span>
    </div>

    <div class="d-flex">
        <span class="mr-2 categories">
            {{ icon_elem('folderFill') }}
            @foreach ($article->categories as $category)
                <a href="#">{{ $category->title }}</a>,
            @endforeach
        </span>
        <span class="ml-auto ml-lg-2 tags">
            {{ icon_elem('tagsFill') }}
            @foreach ($article->tags as $tag)
                <a href="#">{{ $tag->title }}</a>,
            @endforeach
        </span>
    </div>
</div>
