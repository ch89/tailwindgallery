<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Photo;
use App\Notifications\PhotoCommented;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Photo $photo)
    {   
        return $photo->comments()->paginate(5);
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
    public function store(Photo $photo)
    {
        $data = request()->validate(["content" => "required"]);

        $data["user_id"] = auth()->id();

        // Notification::send($photo->subscribers, new PhotoCommented($photo));

        $subscribers = $photo->subscribers()->where("id", "!=", auth()->id())->get();

        Notification::send($subscribers, new PhotoCommented($photo));

        return $photo->comments()->create($data)->load("user");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize($comment->photo);

        $comment->photo->update(["comment_id" => $comment->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $this->authorize($comment);
        
        $comment->delete();
    }
}
