<?php

namespace App\Http\Controllers\Uploads;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ArticleController extends Controller
{
    public function article(Request $request){

        if ($request->hasFile('image')){
            $img = Image::make($request->file('image'));
            $image = $request->file('image');
            $size = $img->filesize();
            $width = $img->width();
            if ($size > 2048000){
                return response()->json([
                    'error' => 1,
                    'message' => Lang::get('files.size_image', ['name' => $image->getClientOriginalName()])
                ]);
            }
            if ($width < 480){
                return response()->json([
                    'error' => 1,
                    'message' => Lang::get('files.width_image', ['name' => $request->file('image')])
                ]);
            }
            $fileName = $image->getClientOriginalName();
            //$fileName = $image->getClientOriginalName().'-'.Str::slug(Carbon::now(), '-').'.'.$image->getClientOriginalExtension();


            if(!Storage::disk('public')->exists('uploads/tmp/'.Carbon::now()->year.'/'.Carbon::now()->month.'/'.Carbon::now()->day)) {
                Storage::disk('public')->makeDirectory('uploads/tmp/'.Carbon::now()->year.'/'.Carbon::now()->month.'/'.Carbon::now()->day, 0775, true); //creates directory
            }

            if (!empty($fileName)){
                Storage::disk('public')->put('uploads/tmp/'.Carbon::now()->year.'/'.Carbon::now()->month.'/'.Carbon::now()->day.'/'.$fileName, file_get_contents($image));
            }

            /*if(!Storage::disk('public')->exists('uploads/images/articles/'.Auth::user()->id)) {
                Storage::disk('public')->makeDirectory('uploads/images/articles/'.Auth::user()->id, 0775, true); //creates directory
            }
            if (!empty($fileName)){
                Storage::delete('uploads/images/articles/'.Auth::user()->id.'/'.Auth::user()->attributes->avatar);
                Storage::disk('public')->put('uploads/images/articles/'.Auth::user()->id.'/'.$fileName, file_get_contents($image));
            }*/

            return response()->json([
                'error' => 0,
                'filename' => 'uploads/tmp/'.Carbon::now()->year.'/'.Carbon::now()->month.'/'.Carbon::now()->day.'/'.$fileName
            ]);

        }

    }


}
