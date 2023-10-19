<?php

namespace App\Imports;

use App\Models\ExcelData;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class PostsImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
//    public function model(array $row)
//    {
//        return new ExcelData([
//            'post_id' => $row[0],
//            'author_name' => $row[1],
//            'title' => $row[2],
//            'email' => $row[3],
//        ]);
//    }
    public function collection(Collection $collection)
    {
        // TODO: Implement collection() method.
        foreach ($collection as $row) {
            $rowData = $row->toArray();

            if (empty($rowData)) {
                continue;
            }

            $user = User::firstWhere('email', $row[3]);
            if (empty($user)) {
                $user = new User();
            }
            $user->fill([
                'email' => $row[3],
                'user_type' => 'author',
                'role_id' => 0,
            ])->save();

            $post = Post::firstWhere('title', $row[2]);
            if (empty($post)) {
                $post = new Post();
            }

            $post->fill([
                'author_id' => $user->id,
                'title' => $row[2],
                'status' => 'active',
            ])->save();
        }
    }
}
