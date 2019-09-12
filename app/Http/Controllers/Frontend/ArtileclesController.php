<?php

namespace App\Http\Controllers\Frontend;

use App\Article;
use App\ArticleGallery;
use App\ArticleTag;
use App\Tag;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ArticlesController extends Controller
{
    public function add(){
        return view('frontend.add-article');
    }

    public function post($slug){
        $article = Article::where('slug', $slug)->first();
        $user = User::where('id', $article->user_id)->first();
        $tags = DB::table('tags')
            ->leftJoin('article_tags', 'tags.id', 'article_tags.tag_id')
            ->where('article_tags.article_id', $article->id)
            ->select('tags.title', 'tags.slug')->get();

        event('postHasViewed', $article);
        return view('frontend.post',[
            'article' => $article,
            'tags' => $tags,
            'user' => $user
        ]);
    }

    public function posts()
    {
        $articles = Article::where('published', '=', 1)->orderBy('view', 'desc')->paginate(15);
        return view('frontend.articles',[
            'articles' => $articles
        ]);
    }

    public function tagsArticles($slug){
        $tag = Tag::where('slug', $slug)->first();
        $articles = DB::table('articles')
            ->leftJoin('article_tags', 'articles.id', 'article_tags.article_id')
            ->select('articles.*')
            ->where('article_tags.tag_id', $tag->id)
            ->where('articles.published', '=', 1)->orderBy('articles.view', 'desc')->paginate(15);




        return view('frontend.post-tag', compact('articles'));
    }


    public function save(Request $request){
        $articles = json_decode($request->articles); //Массив блоков
        $tags = json_decode($request->tags); //Выбранные теги, присутствующие в базе
        if ($request->sourceradio == 0) $source = null; //Если источник не выбран
        if ($request->sourceradio == 1){ //Проверяем указанный источник
            if (!empty(htmlspecialchars($request->sourcearticle))){
                $source = htmlspecialchars($request->sourcearticle);
            }else $source = null;
        }

        $errors_m = '';

        $v = Validator::make($request->all(), [
            'title' => 'required|max:255|unique:articles,title',
        ]);

        if ($v->fails())
        {
            $errors = $v->errors();
            foreach ($errors->all() as $error){
                $errors_m.= $error;
            }
            return response()
                ->json([
                    'message' => $errors_m,
                    'error' => 1,
                ], 200);
        }

        if (empty(htmlspecialchars($request->title))){
            return response()->json([
                'error' => 1,
                'message' => Lang::get('articles.empty_title'),
            ]);
        }
        if (empty(htmlspecialchars($request->description))){
            return response()->json([
                'error' => 1,
                'message' => Lang::get('articles.empty_description'),
            ]);
        }


        $create = Article::create([
            'title' => htmlspecialchars($request->title),
            'description' => htmlspecialchars($request->description),
            'image' => '',
            'slug' => Str::slug(htmlspecialchars($request->title),'-'),
            'category' => 0,
            'source' => $source,
            'user_id' => Auth::user()->id,
            'published' => 0,
            'moderation' => 0,
            'view' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()

        ]);
        if ($create){
            if(!Storage::disk('public')->exists('uploads/post/'.Carbon::now()->year.'/'.Carbon::now()->month.'/'.Carbon::now()->day.'/'.$create->id)) {
                Storage::disk('public')->makeDirectory('uploads/post/'.Carbon::now()->year.'/'.Carbon::now()->month.'/'.Carbon::now()->day.'/'.$create->id, 0775, true); //creates directory
            }
            if ($tags){
                foreach ($tags as $tag) {
                    ArticleTag::create([
                        'article_id' => $create->id,
                        'tag_id' => $tag,
                    ]);
                }
            }
            //Теги пользователя
            if (!empty(htmlspecialchars($request->tagsuser))){
                $words = explode(',', $request->tagsuser);
                foreach($words as $word) {
                    if(preg_match("/([a-zA-Zа-яА-Я]+)/", $word)) {
                        $tag = Tag::where('title', $word)->first();
                        if ($tag){
                            ArticleTag::create([
                                'article_id' => $create->id,
                                'tag_id' => $tag->id,
                            ]);
                        }else{
                            $newTag = Tag::create([
                                'title' => htmlspecialchars($word),
                                'slug' => htmlspecialchars(Str::slug($word,'-')),
                            ]);
                            if ($newTag){
                                ArticleTag::create([
                                    'article_id' => $create->id,
                                    'tag_id' => $newTag->id,
                                ]);
                            }
                        }
                    }

                }
            }
            foreach ($articles as $row=>$article){
                if (!empty(htmlspecialchars($article->title)) or !empty(htmlspecialchars($article->description)) or !empty(htmlspecialchars($article->image))){

                    if (!empty(htmlspecialchars($article->image))){
                        $imageName = pathinfo(htmlspecialchars($article->image));
                        if (Storage::disk('public')->move($article->image, 'uploads/post/'.Carbon::now()->year.'/'.Carbon::now()->month.'/'.Carbon::now()->day.'/'.$create->id.'/'.$imageName['basename'])){
                            $gallery = 'uploads/post/'.Carbon::now()->year.'/'.Carbon::now()->month.'/'.Carbon::now()->day.'/'.$create->id.'/'.$imageName['basename'];
                        }else $gallery = htmlspecialchars($article->image);

                    }else $gallery = null;

                    if ($row == 0) { //Первый блок, берем с него фото
                        Article::where('id', $create->id)->first()->update([
                            'image' => $gallery
                        ]);
                    }
                    ArticleGallery::create([
                        'article_id' => $create->id,
                        'title' => htmlspecialchars($article->title),
                        'description' => htmlspecialchars($article->description),
                        'image' => $gallery,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
            }
        }


        return response()->json([
            'error' => 0,
            'message' => Lang::get('article.success'),
            'link' => '/posts/'.$create->slug
        ]);
    }
}
