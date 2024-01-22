<div id="side-menu" class="border border-warning">
    @foreach($categories as $category)
        <a class="text-body-secondary d-flex" href="{{route('currentCatalog', $category->id)}}">
            <img class="category-image" src="{{ asset('storage') . "/icons/" . $category->image }}" alt="{{ $category->name }}">
            &nbsp;
            {{ $category->name }}
        </a>
    @endforeach
</div>
