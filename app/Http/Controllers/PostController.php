<?php

namespace App\Http\Controllers;

use App\Post;
use App\Product;
use App\Tag;
use App\Recruit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Requests\NewPostRequest;
use Illuminate\Database\Eloquent\Builder;

class PostController extends Controller
{
    // 投稿
    // 投稿一覧
    public function index(Request $request)
    {
        $tag = $request->tag;
        $posts = Post::select('id', 'user_id', 'title','message', 'created_at')
        ->whereNull('recruit_id')->where('message', 'like', "%$request->freeword%")
        ->with(['user:id,name,thumbnail', 'products:id,name,type', 'tags'])
        ->when($tag, function ($query, $tag){
            return $query->whereHas('tags', function($query) use($tag) {
                return $query->where('id', $tag);
            });
        })
        ->orderBy(Post::CREATED_AT, 'desc')->paginate(10);
        return $posts;
    }
    // 投稿詳細
    public function post(string $id)
    {
        $post = Post::select('id', 'user_id', 'title', 'message', 'created_at')->where('id', $id)->with(['user:id,name,thumbnail', 'tags', 'comments', 'products:name,type'])->get();
        return $post;
    }
    // 投稿機能
    public function create(NewPostRequest $request)
    {
        $request->recruit_id = null;
        $post = new Post();
        $post->createPost($request);
        $request->tags->each(function ($tagName) use ($post) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $post->tags()->attach($tag);
        });
        if ($request->type === "0") {
            foreach ($request->picture_files as $file) {
                $product = new Product();
                $product->createPostPictures($post, $request->type, $file);
            }
        }else if($request->type === "1"){
            $product = new Product();
            $product->createPostMovie($post, $request->type, $request->movie_file);
        }else if($request->type === "2"){
            $product = new Product();
            $product->createPostYoutube($post, $request->type, $request->youtube_path);
        }
    
        return response($post, 201);
    }

    // 投稿削除
    public function destroy(string $postId){

        $post = Post::where('id', $postId)->where('user_id', Auth::user()->id)->first();
        if(!$post){
            return false;
        }else{
            $post->postDelete($postId);
        }

        return $post;
    }

    // 相方募集
    // 相方募集一覧
    public function recruit_index(Request $request)
    {
        $tag = $request->tag;
        $prefecture = $request->prefecture;
        $region = $request->region;
        $generation = $request->generation;
        $posts = Post::select('id', 'user_id', 'title','message', 'recruit_id', 'created_at')
            ->whereNotNull('recruit_id')->where('message', 'like', "%$request->freeword%")
            ->with(['user:id,name,thumbnail', 'products:id,name,type', 'tags', 'recruit.prefecture','recruit.prefecture.region', 'recruit.generation'])
            ->when($tag, function ($query, $tag){
                return $query->whereHas('tags', function($query) use($tag) {
                    return $query->where('id', $tag);
                });
            })
            ->when($prefecture, function ($query, $prefecture){
                return $query->whereHas('recruit.prefecture', function($query) use($prefecture) {
                    return $query->where('id', $prefecture);
                });
            })
            ->when($region, function ($query, $region){
                return $query->whereHas('recruit.prefecture.region', function($query) use($region) {
                    return $query->where('id', $region);
                });
            })
            ->when($generation, function ($query, $generation){
                return $query->whereHas('recruit.generation', function($query) use($generation) {
                    return $query->where('id', $generation);
                });
            })
        ->orderBy(Post::CREATED_AT, 'desc')->paginate(10);
        return $posts;
    }

    public function recruit_create(NewPostRequest $request)
    {
        $recruit = new Recruit();
        $recruit->createRecruit($request);
        $request->recruit_id = $recruit->id;
        $post = new Post();
        $post->createPost($request);
        $request->tags->each(function ($tagName) use ($post) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $post->tags()->attach($tag);
        });
        if ($request->type === "0") {
            foreach ($request->picture_files as $file) {
                $product = new Product();
                $product->createPostPictures($post, $request->type, $file);
            }
        }else if($request->type === "1"){
            $product = new Product();
            $product->createPostMovie($post, $request->type, $request->movie_file);
        }else if($request->type === "2"){
            $product = new Product();
            $product->createPostYoutube($post, $request->type, $request->youtube_path);
        }
    
        return response($post, 201);
    }
}
