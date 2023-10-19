<?php

namespace App\Http\Controllers;

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
        $path = request()->file('file')->getRealPath();
        Excel::import(new PostsImport, $path);

        // handle data from ExcelData to User and Post
        $excelData = ExcelData::all();
        $users = User::all();
        foreach ($excelData as $data) {
            $user = $users->where('email', $data->email)->first();
            // if user not exist, create new user
            if (!$user) {
                $user = User::create([
                    'email' => $data->email,
                    'role_id' => 1, //author
                ]);
                // create new post
                Post::create([
                    'author_id' => $user->id,
                    'title' => $data->title,
                    'status' => 'active',
                ]);
            }
            // if user exist, create new post
            else {
                Post::create([
                    'author_id' => $user->id,
                    'title' => $data->title,
                    'status' => 'active',
                ]);
            }
        }

        // return back to previous page
        return back();

    }
}
