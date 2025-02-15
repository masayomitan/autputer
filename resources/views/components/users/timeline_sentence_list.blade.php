
    <div class="user-show-select-box">
        @if (isset(auth()->user()->id))
            @if ((auth()->user()->id) == $user->id)
                <select class="select" name="select" onChange="location.href=value;">
                    @foreach ($sentence_status_list as $status_id => $status_text)
                        <option @if($request_status_id == $status_id) selected @endif value="{{ url()->current() }}?status={{ $status_id }}">
                            {{ $status_text }}
                        </option>
                    @endforeach
                </select>
            @endif
        @endif
    </div>

<div class="timelines">


    @if ($timelines->count())
    @foreach ($timelines as $timeline)
    <div class="timeline-box">
        <div class="timeline-book-box">
            <a href="{{ route('books.show', ['book'=>$timeline->book_id])}}">
            <img class="timeline-book-image" src="{{ $timeline->book_image }}"></a>
            <p class="timeline-book-title">{!! nl2br(e(Str::limit($timeline->title, 18))) !!}</p>
            <p class="timeline-book-author">{!! nl2br(e(Str::limit($timeline->author, 18))) !!}</p>
        </div>

        <div class="timeline-sentence-box">
            <p class="timeline-book-text">{{$timeline->text_1}}</p>
            <p class="timeline-book-text">{{$timeline->text_2}}</p>
            <p class="timeline-book-text">{{$timeline->text_3}}</p>
            <div class="timeline-favorite">
                    <img class="timeline-favorite-icon" src="{{ asset('image/heart.png')}}">
                <div class="timeline-favorite-count">
                    {{ count($timeline->favorites) }}
                </div>
                @if ($request_status_id == 1)
                <a href="{{ url('sentences/' .$timeline->id .'/edit') }}" class="user-confirm-edit-button">編集して公開する</a>
                @endif
            </div>
        </div>
        <div class="timeline-user-box">
            @if (isset($timeline->user->profile_image))
                <img class="timeline-user-image" src="{{ $timeline->user->profile_image}}">
            @else
                <img class="timeline-user-image" src="{{ asset('image/noname.jpg')}}"></a>
            @endif
            <p class="timeline-user-name">{!! nl2br(e(Str::limit($timeline->user->name, 16))) !!}</p>
            <p class="timeline-date">{{ $timeline->created_at->format('Y-m-d H:i') }}</p>
                @if (isset(auth()->user()->id))
                @if (auth()->user()->id == $user->id)
                    <div class="timeline-delete">
                        <form method="post" action="{{ url('sentences/' .$timeline->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick='return confirm("本当に削除しますか？");'>
                                3行削除</button>
                        </form>
                    </div>
                @endif
                @endif
        </div>
    </div>
    @endforeach
    @else
        <div class="user-show-select-box">
            まだ投稿がありません。
        </div>
    @endif
    {{ $timelines->links() }}
</div>
