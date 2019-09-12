<?php

namespace App\Http\Controllers\Other;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    public function getTags(){
        $tags = Tag::all();
        return response()->json($tags);
    }
}
