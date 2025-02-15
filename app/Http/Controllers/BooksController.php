<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Favorite;
use App\Models\Sentence;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class BooksController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Book $book, Tag $tags, User $user)
    {

        $books["all"] = Book::orderBy('updated_at', "desc")->take(8)->get();
        $books["new"] = $book->getBooksWithNewSentences($book);
        $books["pop"] = $book->getBooksWithPopularSentences($book);

        $popular_tags = $tags->getPopularTags();
        $popular_users = $user->getPopularUsers();
        $keyword = $request->input("keyword");
        return view('books.index',compact('books'), [
            'keyword' => $keyword,
            'request' => $request,
            'popular_tags' => $popular_tags,
            'popular_users' => $popular_users,
        ]);
    }

    public function put_new_sentence(Request $request, Book $book, Tag $tags, User $user)
    {

        $books= $book->getAllBooksWithNewSentences($book);

        $popular_tags = $tags->getPopularTags();
        $popular_users = $user->getPopularUsers();
        $keyword = $request->input("keyword");
        return view('books.put_new_sentence',compact('books'), [
            'keyword' => $keyword,
            'request' => $request,
            'popular_tags' => $popular_tags,
            'popular_users' => $popular_users,
        ]);
    }

    public function put_popular_sentence(Request $request, Book $book, Tag $tags, User $user)
    {
        $books = $book->getAllBooksWithPopularSentences($book);

        $popular_tags = $tags->getPopularTags();
        $popular_users = $user->getPopularUsers();
        $keyword = $request->input("keyword");
        return view('books.put_popular_sentence',compact('books'), [
            'keyword' => $keyword,
            'request' => $request,
            'popular_tags' => $popular_tags,
            'popular_users' => $popular_users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //ok
    public function create(Request $request)
    {
        $user = auth()->user();
        $keyword = $request->input("keyword");

        return view('books.create',[
            'keyword' => $keyword,
            'user' => $user,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Book $book, Tag $tag)
    {
        $data = $request->all();
        $data["tags"] = array_filter($data["tags"]);    //array_filterで連想配列の空チェック,空削除でエラー防ぐ

        $file_name = $request->file('book_image')->getClientOriginalName();
        $request->file('book_image')->storeAs('/public/book_image',$file_name);

        $file_name = $request->file('book_image');
        $book_image = Storage::disk('s3')->putFile('book_image', $file_name, 'public');
        $data["book_image"] = Storage::disk('s3')->url($book_image);

        $rules = [
            'title' =>  ['string', 'max:50'],
            'author' => ['string', 'max:30'],
            'tags.*' =>   ['string', 'max:10'],
        ];

        $messages = [
            'title.max'     => 'タイトルは:max文字以内で入力してください。',
            'author.max'    => '著者名は:max文字以内で入力してください。',
            'tags.*.max'    => 'タグは10文字以内で入力してください',
        ];

        $validator = Validator::make($data, $rules, $messages);
        $validated = $validator->validate();

        $book->bookStore($data);

        $tag_name = $data["tags"];
        if(empty($tag_name)) {
            return redirect('/books')->with(['validated'=>$validated]);
        } else {
            $tag->tagStore($data["tags"]);        //タグ登録メソッド
            $tag_ids = $tag->getTagIds($data["tags"]);    //$tagテーブルに挿入した値の名前からidを取得し中間テーブルへ
            $book->bookTagSync($tag_ids);         //中間テーブルにidを設置
        }

        return redirect('/books')->with(['validated'=>$validated]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Book $book, Sentence $sentence, Favorite $favorite)
    {

        $user = auth()->user();
        $book = $book->getBook($book->id);

        $data_list = [
            1 => "最新順",
            2 => "評価順"
        ];
        switch($request->data_id){
            case 1:
                $sentences = $sentence->getSentence($book->id);
            break;
            case 2:
                $sentences = $sentence->sentenceWithCount($book->id);
            break;
            default:
                $sentences = $sentence->getSentence($book->id);
        }
        $favorite = $favorite->all();

        return view('books.show', compact('book'),[
            'user' => $user,
            'book' => $book,
            'sentences' => $sentences,
            'data_list' => $data_list,
            'request' => $request,
            'favorite' => $favorite,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {

    }

}
