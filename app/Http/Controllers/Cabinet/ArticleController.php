<?php

namespace App\Http\Controllers\Cabinet;

use App\Article;
use App\ArticleGallery;
use App\ArticleTag;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function articles(){
        return view('cabinet.articles');
    }

    public function getArticles(){
        $articles = Article::where('user_id', Auth::user()->id)->get();
        return response()->json($articles);
    }

    public function edit($slug){
        return view('cabinet.edit-article',[
            'article' => Article::where('slug', $slug)->first()
        ]);
    }
    public function editArticle(Request $request){
        $articles = Article::where('id', $request->id)->first();
        $articles_gallery = ArticleGallery::where('article_id', $request->id)->get();
        $tags = ArticleTag::where('article_id', $request->id)->select('tag_id')->get();

        return response()->json([
            'article' => $articles,
            'galleries' => $articles_gallery,
            'tags' => $tags
        ]);
    }
    public function deleteArticleGallery(Request $request){
        $image = ArticleGallery::where('id', $request->id)->first();
        $article = ArticleGallery::where('id', $request->id)->first()->delete();
        if ($article){
            Storage::disk('public')->delete($image);
        }
        return response()->json([
            'error' => 0
        ]);
    }

    public function deleteArticle(Request $request){
        $post = Article::where('id', $request->id)->select('image')->first();
        $info = pathinfo($post->image);
        $path = $info['dirname'];
        $delete = Article::where('id', $request->id)->first()->delete();
        if ($delete){
            Storage::disk('public')->deleteDirectory($path);
            $tags = ArticleTag::where('article_id', $request->id)->delete();
            return response()->json([
                'error' => 0,
                'message' => Lang::get('articles.delete_success')
            ]);
        }
        return response()->json([
            'error' => 1,
            'message' => Lang::get('articles.delete_error')
        ]);
    }

    public function updateArticle(Request $request){
        $articles = json_decode($request->articles); //Массив блоков
        $tags = json_decode($request->tags); //Выбранные теги, присутствующие в базе

        $articleBase = Article::where('id',$request->id)->first();

        if ($request->sourceradio == 0) $source = null; //Если источник не выбран
        if ($request->sourceradio == 1){ //Проверяем указанный источник
            if (!empty(htmlspecialchars($request->sourcearticle))){
                $source = htmlspecialchars($request->sourcearticle);
            }else $source = null;
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


        $update = Article::where('id', $request->id)->first()->update([
            'title' => htmlspecialchars($request->title),
            'description' => htmlspecialchars($request->description),
            'source' => $source,
            'user_id' => Auth::user()->id,
            'updated_at' => Carbon::now()

        ]);
        if ($update){
            if ($tags){
                ArticleTag::where('article_id', $request->id)->delete();
                foreach ($tags as $tag) {

                    ArticleTag::create([
                        'article_id' => $request->id,
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
                                'article_id' => $request->id,
                                'tag_id' => $tag->id,
                            ]);
                        }else{
                            $newTag = Tag::create([
                                'title' => htmlspecialchars($word),
                                'slug' => htmlspecialchars(Str::slug($word,'-')),
                            ]);
                            if ($newTag){
                                ArticleTag::create([
                                    'article_id' => $request->id,
                                    'tag_id' => $newTag->id,
                                ]);
                            }
                        }
                    }

                }
            }
            foreach ($articles as $row=>$article){
                if (!empty(htmlspecialchars($article->title)) or !empty(htmlspecialchars($article->description)) or !empty(htmlspecialchars($article->image))) {

                    if ($article->id > 0) {
                        $galleryBase = ArticleGallery::where('id', $article->id)->first();
                        if ($galleryBase->image != $article->image) {
                            $imageName = pathinfo(htmlspecialchars($article->image));
                            if (!empty(htmlspecialchars($article->image))) {
                                $exists = Storage::disk('public')->exists($article->image); //Проверяем наличие файла по названию
                                if ($exists){
                                    $gallery = $article->image;
                                }else{
                                    if (Storage::disk('public')->move($article->image, 'uploads/post/' . Carbon::now()->year . '/' . Carbon::now()->month . '/' . Carbon::now()->day . '/' . $request->id . '/' . $imageName['basename'])) {
                                        $gallery = 'uploads/post/' . Carbon::now()->year . '/' . Carbon::now()->month . '/' . Carbon::now()->day . '/' . $request->id . '/' . $imageName['basename'];
                                    } else $gallery = htmlspecialchars($article->image);
                                }
                            }else $gallery = null;
                        }else $gallery = $article->image;

                        ArticleGallery::where('id', $article->id)->first()->update([
                            'title' => htmlspecialchars($article->title),
                            'description' => htmlspecialchars($article->description),
                            'image' => $gallery,
                            'updated_at' => Carbon::now()
                        ]);

                    }else{
                        $imageName = pathinfo(htmlspecialchars($article->image));
                        if (!empty(htmlspecialchars($article->image))) {
                            $exists = Storage::disk('public')->exists($article->image); //Проверяем наличие файла по названию
                            if ($exists){
                                $gallery = $article->image;
                            }else{
                                if (Storage::disk('public')->move($article->image, 'uploads/post/' . Carbon::now()->year . '/' . Carbon::now()->month . '/' . Carbon::now()->day . '/' . $request->id . '/' . $imageName['basename'])) {
                                    $gallery = 'uploads/post/' . Carbon::now()->year . '/' . Carbon::now()->month . '/' . Carbon::now()->day . '/' . $request->id . '/' . $imageName['basename'];
                                } else $gallery = htmlspecialchars($article->image);
                            }

                        } else $gallery = null;

                        ArticleGallery::create([
                            'article_id' => $request->id,
                            'title' => htmlspecialchars($article->title),
                            'description' => htmlspecialchars($article->description),
                            'image' => $gallery,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                    }

                    if ($row == 0) { //Первый блок, берем с него фото
                        if ($articleBase->image != $article->image) {
                            Article::where('id', $request->id)->first()->update([
                                'image' => $gallery
                            ]);
                        }

                    }
                }

            }
        }

        $articleUpdate = Article::where('id', $request->id)->first();
        return response()->json([
            'error' => 0,
            'message' => Lang::get('article.success'),
            'link' => '/posts/'.$articleUpdate->slug
        ]);
    }
}
