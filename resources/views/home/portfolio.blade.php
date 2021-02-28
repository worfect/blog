<div class="show-portfolio-home">
    <div class="group-portfolio">
        @foreach($items as $item)
           <div class="portfolio-item">
            <a href="{{ route('portfolio.show', $item->id) }}">
                <img src="{{ $item->image }}" alt="" />
                {{ $item->customer }}
            </a>
            </div>
        @endforeach
    </div>
    <a href="{{ route('portfolio.index') }}">Show all projects...</a>
</div>

