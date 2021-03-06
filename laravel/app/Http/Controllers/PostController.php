<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::all();
        return view('posts.index', ['posts' => $posts]);
    }

    public function search(Request $request)
    {
        $posts = Post::where('body', 'like', "%{$request->search}%")->paginate(5);

        return view('posts.index', ['posts' => $posts ]);       

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = Auth::id();
        //インスタンス作成
        $post = new Post();
        
        $post->body = $request->body;
        $post->user_id = $id;

        $post->save();

       return redirect()->to('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $usr_id = $post->user_id;
        $user = DB::table('users')->where('id', $usr_id)->first();
        

        return view('posts.detail',['post' => $post,'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $usr_id = $post->user_id;
        $post = \App\Post::findOrFail($id);

        return view('posts.edit',['post' => $post]);
        // return view('posts.edit');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->post_id;
        
        //レコードを検索
        $post = Post::findOrFail($id);
        
        $post->body = $request->body;
        
        //保存（更新）
        $post->save();
        
        return redirect()->to('/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = \App\Post::find($id);
        //削除
        $post->delete();

        return redirect()->to('/posts');
    }
}


// <!-- <?php

// namespace App\Http\Controllers;

// use App\Post;
// use Illuminate\Http\Request;

// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;


// class PostController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function index()
//     {
//         $posts = Post::all();
//         return view('posts.index', ['posts' => $posts]);
//     }

//     /**
//      * Show the form for creating a new resource.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function create()
//     {
//         return view('posts.create');
//     }

//     /**
//      * Store a newly created resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */
//     public function store(Request $request)
//     {
//         $id = Auth::id();
//         //インスタンス作成
//         $post = new Post();
        
//         $post->body = $request->body;
//         $post->user_id = $id;

//         $post->save();

//        return redirect()->to('/posts');
//     }

//     /**
//      * Display the specified resource.
//      *
//      * @param  \App\Post  $post
//      * @return \Illuminate\Http\Response
//      */
//     public function show(Post $post)
//     {
//         $usr_id = $post->user_id;
//         $user = DB::table('users')->where('id', $usr_id)->first();
        

//         return view('posts.detail',['post' => $post,'user' => $user]);
//     }

//     /**
//      * Show the form for editing the specified resource.
//      *
//      * @param  \App\Post  $post
//      * @return \Illuminate\Http\Response
//      */
//     public function edit($post_id)
//     {
//          $post = Post::findOrFail($post_id);
//          return view('posts.edit',['post' => $post]);
//          // return view('posts.edit');
//     }

//     /**
//      * Update the specified resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  \App\Post  $post
//      * @return \Illuminate\Http\Response
//      */
//     public function update(Request $request)
//     {
//         $id = $request->post_id;
        
//         //レコードを検索
//         $post = Post::findOrFail($id);
        
//         $post->body = $request->body;
        
//         //保存（更新）
//         $post->save();
        
//         return redirect()->to('/posts');
//     }

//     /**
//      * Remove the specified resource from storage.
//      *
//      * @param  \App\Post  $post
//      * @return \Illuminate\Http\Response
//      */
//     public function destroy(Post $id)
//     {
//         $post = Post::find($id);
//         //削除
//         $post->delete();

//         return redirect()->to('/posts');
//     }
// } -->
