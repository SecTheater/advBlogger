<?php

namespace App\Http\Controllers;

use App\Post;
use Sentinel;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function listUnApproved(){
        $posts = \App\Post::whereApproved(0)->get();
        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getByArchive(){
        //archives/{month}/year
       $posts = Post::listApproved()->filter(request()->route('month'),request()->route('year'))->get();
        return view('posts.index')->with('posts',$posts);
    }
    public function index()
    {
        $posts = Post::listApproved()->get();
        
       return view('posts.index')->with('posts',$posts);
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
    public function store()
    {
       request()->validate([
            'title' => 'required|string|unique:posts,title|min:3|max:32|alpha_dash',
            'body' => [
                'required','string','regex:/^[a-zA-Z0-9-_. ]*$/','min:6','max:300'
            ],
            'imagePath' => 'nullable|max:1999|image|mimes:png,jpg,jpeg',
            'tags' => [
                'required','regex:/^[a-zA-Z0-9-_., ]*$/','min:3','max:32','string'
            ]
        ]);
       if(\App\Tag::assignTags(request('tags'))){
            if(request()->hasFile('imagePath')){
                $file_with_ext = request()->file('imagePath')->getClientOriginalName();
                $file_ext   = request()->file('imagePath')->getClientOriginalExtension();
                $file_name_new = sha1(str_random(40) . time()) . '.' . $file_ext;
                $file_path = request()->file('imagePath')->move(public_path(). '/images/',$file_name_new);
           }
            $post =Post::forceCreate([
                'title' => request('title'),
                'body' => request('body'),
                'admin_id' => Sentinel::getUser()->id,
                'imagePath' => $file_name_new ?? NULL
            ]);
            if(is_array(\Session::get('tags'))){
                foreach(\Session::get('tags') as $tag){
                    $post->tags()->attach($tag);
                }
            }else{
                $post->tags()->attach(\Session::get('tags'));
                
            }
            \Session::forget('tags');
           return redirect()->route('posts.index')->with('success','Post Has Been Created Successfully');
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
       return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if(Sentinel::getUser()->id != $post->admin_id){
            return redirect()->route('posts.index')->with('error','Unauthorized Page');
        }
        return view('posts.edit')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post)
    {
        request()->validate([
            'title' => "required|string|unique:posts,title,$post->id|min:3|max:32|alpha_dash",
            'body' => [
                'required','string','regex:/^[a-zA-Z0-9-_. ]*$/','min:6','max:300'
            ],
            'imagePath' => 'nullable|max:1999|image|mimes:png,jpg,jpeg',
            'tags' => [
                'required','regex:/^[a-zA-Z0-9-_., ]*$/','min:3','max:32','string'
            ]
        ]);
        if(\App\Tag::assignTags(request('tags'))){
           if(request()->hasFile('imagePath')){
                $file_with_ext = request()->file('imagePath')->getClientOriginalName();
                $file_ext   = request()->file('imagePath')->getClientOriginalExtension();
                $file_name_new = sha1(str_random(40) . time()) . '.' . $file_ext;
                $file_path = request()->file('imagePath')->move(public_path(). '/images/',$file_name_new);
            }
            $post = Post::whereTitle($post->title)->update([   
                'title' => request('title'),
                'body' => request('body'),
                'admin_id' => Sentinel::getUser()->id,
                'imagePath' => $file_name_new ?? NULL
            ]);

            if($post){
                $post = Post::whereTitle(request('title'))->first();
                if(is_array(\Session::get('tags'))){
                    for ($i = 0; $i < count(\Session::get('tags')); $i++) {
                        if($i === 0){
                            $post->tags()->sync(\Session::get('tags')[$i]);
                            continue;
                        }
                        $post->tags()->sync(\Session::get('tags')[$i],false);
                    }
                }else{
                    $post->tags()->sync(\Session::get('tags'));
                }
                \Session::forget('tags');
                return redirect()->route('posts.index')->with('success','Post Has Been Updated Successfully');
            }
            
        }
        return redirect()->route('posts.index')->with('error','Post Could not be updated successfully');        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if(Sentinel::getUser()->id != $post->admin_id){
            return redirect('/posts')->with('error','Unauthorized Page');
        }
        if($post->imagePath !== NULL)
        \File::delete('images/'.$post->imagePath);
        $post->delete();
        return redirect('/posts')->with('success','Post deleted');
    }
}
