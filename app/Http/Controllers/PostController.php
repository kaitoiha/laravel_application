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
}
