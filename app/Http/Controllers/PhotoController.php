<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return auth()->user()->photos()->with("channel")->get();
        // return auth()->user()->photos;

        $query = Photo::query();

        if(request()->filled("channel_id")) {
            $query->where("channel_id", request("channel_id"));
        }

        return $query->where("user_id", auth()->id())->paginate(request("limit", 2));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            "title" => "required",
            "content" => "required",
            "channel_id" => "required|exists:channels,id",
            "image" => "required|image"
        ]);

        $data["image"] = request("image")->store("images");

        return auth()->user()->photos()->create($data)->load("channel");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        $photo->delete();
    }

    public function like(Photo $photo) {
        auth()->user()->likes()->toggle($photo);
    }

    public function rate(Photo $photo) {
        auth()->user()->ratings()->syncWithoutDetaching([
            $photo->id => request()->validate([
                "rating" => "required|integer|between:1,5"
            ])
        ]);
    }
}
