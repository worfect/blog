<form class="rating-panel">
    <input name="type" value="{{ $item->name }}" type="hidden">
    <input name="id" value="{{ $item->id }}" type="hidden">
    <button class='@if(Auth::user() and $item->attitude->where('user_id', Auth::id())->where('attitude', -1)->isNotEmpty()) active @endif'
            type="submit" name="attitude" value=-1 @if(!Auth::user()) disabled @endif><i class="fas fa-minus-square"></i></button>

    <div class="current-rating">{{ $item->rating }}</div>
    <button class='@if(Auth::user() and $item->attitude->where('user_id', Auth::id())->where('attitude', 1)->isNotEmpty()) active @endif'
            type="submit" name="attitude" value=1 @if(!Auth::user()) disabled @endif><i class="fas fa-plus-square"></i></button>
</form>
