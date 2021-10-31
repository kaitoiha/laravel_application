<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // 投稿一覧画面表示
    public function index(){
        $posts = Post::all();
        return view("posts.index",["posts" => $posts]);
    }
    // 登録（投稿）画面表示
    public function create(){
        return view("posts.create");
    } 
    // 登録（投稿）処理
    public function store(PostRequest $request){
        $post = new Post;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = Auth::id();

        $post->save();

        return redirect()->route("post.index");
    }
    // 投稿を詳細表示
    public function show($id){
        // 投稿データのIDでモデルから投稿を1件取得
        $post = Post::findOrFail($id);

        // show.blade.phpを表示する(これから作成)
        return view('posts.show', ['post' => $post]);
    }

    // 投稿を編集
    public function edit($id){
        // 投稿データのIDでモデルから投稿を1件取得
        $post = Post::findOrFail($id);

        // 投稿者以外の編集を防ぐ
        if ($post->user_id !== Auth::id()) {
            return redirect('/');
        }

        // edit.blade.phpを表示する(これから作成)
        return view('posts.edit', ['post' => $post]);
    }

    // 投稿編集を更新
    public function update(PostRequest $request, $id){
        // 投稿データのIDでモデルから投稿を1件取得
        $post = Post::findOrFail($id);

        // 投稿者以外の更新を防ぐ
        if ($post->user_id !== Auth::id()) {
            return redirect('/');
        }

        // 編集画面から受け取ったデータをインスタンスに反映
        $post->title = $request->title;
        $post->body = $request->body;

        $post->save(); // DBのレコードを更新

        return redirect('/');
    }

    // 投稿を削除
    public function delete($id){
        // 投稿データのIDでモデルから投稿を1件取得
        $post = Post::findOrFail($id);

        // 投稿者以外の削除を防ぐ
        if ($post->user_id !== Auth::id()) {
            return redirect('/');
        }

        $post->delete(); // DBのレコードを削除

        return redirect('/');
    }
}
