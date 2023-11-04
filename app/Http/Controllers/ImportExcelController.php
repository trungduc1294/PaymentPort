<?php

namespace App\Http\Controllers;

use App\Models\UserPost;
use Illuminate\Http\Request;
use App\Imports\PostsImport;
use Excel;
use App\Models\Post;
use App\Models\User;
use App\Models\ExcelData;

class ImportExcelController extends Controller
{
    public function importExcel(Request $request)
    {
        // logic to import excel file into database with model ExcelData
        Excel::import(new PostsImport, request()->file('file'));

        // handle data from ExcelData to User and Post
//        $excelData = ExcelData::all();
//
//        $users = User::all();
//        foreach ($excelData as $data) {
//                $user = $users->where('email', $data->email)->first();
//
//            if (empty($user)) {
//                $user = new User();
//            }
//
//            $user->fill([
//                'email' => $data->email,
//                'user_type' => 'author',
//                'full_name' => $data->full_name,
//                'role_id' => 0,
//            ])->save();
//
//            $post = Post::firstWhere('title', $data->title);
//            if (empty($post)) {
//                $post = new Post();
//            }
//            $post->fill([
//                'title' => $data->title,
//                'status' => 'active',
//            ])->save();
//
//            $user_post = new UserPost();
//            $user_post->fill([
//                'user_id' => $user->id,
//                'post_id' => $post->id,
//            ])->save();
//        }

        // return back to previous page
        return back();

    }
}
