

    <div class="tab-wrap">
        <div class="tab-content">
            @foreach($tab_info_list as $tab_text => $tab_info)
            <div class="tab-num">
                    <a href="{{ $tab_info['link'] }}">{{$tab_text}}</a>
            </div>
            @endforeach
        </div>
        <div class="tab-name">
            <div class="tab-code">
                投稿数
            </div>
            <div class="tab-code">
                いいね数
            </div>
            <div class="tab-code">
                フォロー
            </div>
            <div class="tab-code">
                フォロワー
            </div>
        </div>
    <div>

