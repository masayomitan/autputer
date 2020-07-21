<h1>詳細画面</h1>
<p><a href="{{ route('books.index')}}">一覧画面</a></p>

<table border="1">
    <tr>
        <th>id</th>
        <th>title</th>
        <th>over_view</th>
        <th>画像</th>
    </tr>
    <tr>
        <td>{{ $book->id }}</td>
        <td>{{ $book->title }}</td>
        <td>{{ $book->over_view }}</td>
        {{-- <img src="/storage{{$book->book_image}}"> --}}
        <img src="{{ URL::to('public/storage') }}/{{ $book->book_image }}" alt="{{ $book->book_image }}" />

    </tr>
</table>
<th><a href="{{ route('sentences.create', ['id' => $book->id]) }}">コメント</a></th>
<div class="col-xs-8 col-xs-offset-2">

    @foreach($sentences as $sentence)
    <tr>
        <td>{{ $sentence->text }}</td>
    </tr>
    @endforeach


<li class="list-group-item">
    <div class="py-3">
        @if($user)
            <form method="POST" action="{{ route('sentences.store') }}">
            @csrf
                <div class="form-group row mb-s0">
                    <div class="col-md-12 p-3 w-100 d-flex">
                            <a href="{{ url('users/' .$user->id) }}" class="text-secondary">&#064;{{ $user->screen_name }}</a>
                            <a href="{{ url('books/' .$book->id) }}" class="text-secondary">&#064;{{ $book->title }}</a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <textarea class="form-control @error('text') is-invalid @enderror" name="text" required rows="4">{{ old('text')}}</textarea>
                <div class="form-group row mb-0">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary">
                            コメントする
                        </button>
                    </div>
                </div>
            </form>
        @else
    </div>
</li>
@endif


