@extends('layouts.app')
@include('layouts.header')

{{ Breadcrumbs::render('sentence.edit', $user, $book, $sentences) }}

<div class="book-sentence-show">

    <div class="book-sentence-box">
        <div class="book-sentence-new"><h1>下書きの完成</h1></div>
            <div class="book-info">
                <img class="book-info-image" src="{{ $book->book_image }}">
                    <div class="book-info-others">
                        <div class="book-info-title">
                            <a {{ url('books/' .$book->id) }}>{{ $book->title }}</a>
                        </div>

                        <div class="book-info-author">
                            <a {{ url('books/' .$book->id) }}>{{ $book->author}}</a>
                        </div>
                    </div>
            </div>
    </div>


    <div class="sentence-create">
        <div class="sentence-create-box">
            <div class="new">打ち間違い等を確認してください。投稿後の修正はできません。(1行につき35文字までです)</div>
            <form method="POST" action="{{ route('sentences.update', $sentences->id) }}">
                @csrf
                @method('PUT')
                <div class="gyo-1"><h3>1行目</h3></div>
                <input class="sentence-create-box-text" type="text" name="text_1" value="{{ $book->text_1 }}" required autofocus>
                <div class="gyo"><h3>2行目</h3></div>
                <input class="sentence-create-box-text" type="text" name="text_2" value="{{ $book->text_2 }}" required>
                <div class="gyo"><h3>3行目</h3></div>
                <input class="sentence-create-box-text" type="text" name="text_3" value="{{ $book->text_3 }}" required>
        </div>

            <div class="sentence-btn">
                    <p><button type="submit" class="sentence-btn-comfirm">
                            投稿する
                    </button></p>
            </div>
        </form>
    </div>
</div>
