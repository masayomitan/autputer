<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\User as AppUser;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class UsersController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(User $user, Request $request)
  {

    if (auth()->user()) {
      //ログインしている場合、自分以外のユーザー情報を取得
      $all_users = $user->getAllUsers(auth()->user()->id);
      return view('users.index', [
        'all_users' => $all_users
      ]);
    } else {
      //ログインしていない場合、全てのユーザー情報を取得
      $all_users = $user->getAllUsers(auth()->user());
      return view('users.index', [
        'all_users' => $all_users
      ]);
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }


  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(User $user, Book $book, Request $request)
  {
    // if (!isset($request["status"])) {
    //   $request["status"] = 0;
    // }

    // #ログインユーザーじゃないユーザーが下書きページに遷移した際、リダイレクトして閲覧を防ぐ
    // if ($request["status"] == 1) {
    //   $is_self_article = $user->isSelfArticle($request, $user);
    //   if (!$is_self_article) {
    //     return redirect($request->path());
    //   }
    // }

    // $timelines = $article->getUserTimeLine($user->id, $request["status"]);
    // $user_info_list = $user->getUserInfoList();
    // $user_info_list["timelines"] = $timelines;
    // $user_info_list["article_status_list"] = ['公開中', '下書き'];
    // $user_info_list["request_status_id"] = $request["status"];

    return view('users.show', $user);
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(User $user)
  {
    $user = auth()->user();
    return view('users.edit', ['user' => $user]);
  }


  public function update(Request $request, User $user)
  {

    $user = User::find(Auth::user()->id);
    $data = $request->all();
    $validator = Validator::make($data, [
      #0-9,英数字,記号の_のみだけ登録できるよう設定
      'screen_name' => ['required', 'regex:/^(\w)+$/', 'max:50', Rule::unique('users')->ignore($user->id)],
      'name' => ['required', 'string', 'max:255'],
      'profile_image' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
      'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)]
    ]);

    $validator->validate();
    $user->userUpdate($data);
    return redirect('users/' . $user->id);

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }

}
