<?php

namespace App\Http\Controllers;

use App\Comment;
use \App\Post;
use \Sentinel;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('comments.index')->with('comments',Comment::all());
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Post $post)
    {
        request()->validate([
            'comment' => 'required|max:500|min:3'
        ]);
        $comment = new Comment;
        $comment->body = request('comment');
        $comment->user_id = Sentinel::getUser()->id;
        $comment->post()->associate($post);
        $comment->save();
        return back()->with('success','Comment Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment) //find(1)
    {
        return view('posts.show')->with('post',$comment->post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment,Post $post)
    {
        return view('posts.show')->with(['comment' => $comment,'post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Comment $comment)
    {
        request()->validate([
            'comment' => 'required|max:500|min:3'
        ]);
        $comment->update([
            'body' => request('comment'),
            'user_id' => Sentinel::getUser()->id
        ]);
        return redirect()->route('posts.show',$post->title)->with('success','Comment Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
       $comment->delete();
       return back()->with('success','Comment Deleted !');

    }
}
