<div class="show-gallery-home">
    <div class="group-gallery">
        @foreach($gallery as $item)
            <div class="card gallery-card" id="gallery-card-{{ $item->id }}">
                <img class="card-img" src="{{ $item->image }}" alt="{{ $item->title }}">
                <div class="" >
                    <div class="card-img-overlay">
                        <p class="card-text">{{ $item->title }}</p>
                        <i class="fas  fa-search-plus icon fa-3x"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <a href="{{ route('gallery.index') }}">Show more photos...</a>
</div>



