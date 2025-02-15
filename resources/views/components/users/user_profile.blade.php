


<div class="users">
    <div class="users-box">
        <div class="user-icon">
            @if (isset($user->profile_image))
                <img class="user-image"  src="{{ $user->profile_image}}">
            @else
                <img class="user-image" src="{{ asset('image/noname.jpg')}}"></a>
            @endif

            <div class="user-confirm">
                <div class="user-confirm-edit">
                    @if (isset(auth()->user()->id))
                    @if (auth()->user()->id == $user->id)
                        <a href="{{ url('users/' .$user->id .'/edit') }}" class="user-confirm-edit-button">編集する</a>
                    @else
                </div>
                <div class="user-confirm-result">
                    @if (auth()->user()->isFollowed($user->id))
                    <div>フォローされています</div>
                    @endif
                </div>
                <div class="follow-box">
                    @if (auth()->user()->isFollowing($user->id))
                        <form action="{{ route('users.unfollow', $user->id) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                                <button type="submit" class="follow-delete">フォロー解除</button>
                        </form>
                        @else
                            <form action="{{ route('users.follow', $user->id) }}" method="POST">
                                {{ csrf_field() }}
                                <button type="submit" class="follow-store">フォローする</button>
                            </form>
                        @endif
                        @endif
                        @endif
                </div>
            </div>
        </div>

            <div class="user-info">
                <div class="user-info-name">
                    {{ $user->name }}さんのページ
                </div>
                <div class="user-info-intr">
                    {{ $user->self_introduction }}
                </div>
            </div>

    </div>
</div>
