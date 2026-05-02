<form action="{{ route('search') }}" method="GET" class="search-wrap">

    <select name="category" class="search-category">
        <option value="">All</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">
                {{ $category->en_category_name }}
            </option>
        @endforeach
    </select>

    <div class="search-divider"></div>

    <input type="text" name="query" class="search-input" placeholder="Search products...">

    <button type="submit" class="search-btn">
        <i class="bi bi-search"></i>
    </button>

</form>