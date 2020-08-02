
 <div class="card">
    <div class="card-header tag-mark">話題のタグ</div>
    <div class="card-body">
    @foreach ($popular_tags as $tag)
        <a href="{{ route('tags.show', ['tag'=>$tag->id]) }}">
        <p>{{$tag->name}}({{$tag->books_count}})</p>
        </a>
    @endforeach
    </div>
</div>
