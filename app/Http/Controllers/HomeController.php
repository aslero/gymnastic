<?php

namespace App\Http\Controllers;
use App\Article;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $articles = Article::where('published', '=', 1)->orderBy('view', 'desc')->paginate(15);
        return view('home',[
            'articles' => $articles
        ]);
    }
}
