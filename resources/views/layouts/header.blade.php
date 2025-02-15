@extends('layouts.app')


<!doctype html>
<html lang="ja">

<meta charset="UTF-8">
<title>サンギョー</title>


<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
<head>
    <meta name=”viewport” content=”width=device-width, initial-scale=1”>
    <link rel="shortcut icon" href="{{ asset('image/favicon/favicon.png') }}">
    <header class="main-header-wrapper">
        <a class="main-header-title" href="{{ route('books.index') }}">
            <img class="main-header-title-log" src="{{ asset('image/title.log.png')}}">
        </a>

        <div class="user-box">
            @if (isset(auth()->user()->id))
                    <a href="{{ route('users.show',auth()->user()->id)}}" src="{{ auth()->user()->profile_image}}">
                @if (isset(auth()->user()->profile_image))
                    <img class="user-header-image" src="{{ auth()->user()->profile_image}}"></a>
                @else
                    <img class="user-header-image" src="{{ asset('image/noname.jpg')}}"></a>
                @endif
            @endif

        <ul id="menu">
            <li><a href="#">Menu</a>
                <ul>
                    @if (isset(auth()->user()->id))
                    <li><a href="{{ route('users.show',auth()->user()->id)}}">マイページ</a></li>
                            <li><a href="{{ route('users.edit',auth()->user()->id)}}">プロフィール編集</a></li>
                            <li><a href="{{ route('users.show',auth()->user()->id)}}?status=1">下書き</a></li>
                            <li><a href="{{ route('books.create') }}">本の新規追加</a></li>
                    @endif

                    @guest
                    <li>
                        <a class="nav-link" href="{{ route('login') }}">{{ __('ログイン') }}</a></li>
                        @if (Route::has('register'))
                    <li>
                        <a class="nav-link" href="{{ route('register') }}">{{ __('新規登録') }}</a></li>@endif
                        @else
                    <li><a  href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            {{ __('ログアウト') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form></li>
                    @endguest
                </ul>
            </li>
        </ul>
    </div>
    </header>
</head>
