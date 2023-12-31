<?php

namespace App\Imports;

use App\Models\Post;
use App\Models\User;
use App\Models\UserPost;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PostsImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $rowData = $row->toArray();

            if (empty($rowData) || empty($rowData[5])) {
                continue;
            } elseif (empty($rowData[2])) {
                $user = User::firstWhere('full_name', $rowData[1]);
                if (empty($user)) {
                    $user = new User();
                }

                $user->fill([
                    'email' => 'noEmail',
                    'user_type' => 'author',
                    'full_name' => $rowData[1],
                    'role_id' => 0,
                ])->save();

                $post = Post::firstWhere('title', $rowData[5]);
                if (empty($post)) {
                    $post = new Post();
                }
                $post->fill([
                    'paper_id' => $rowData[0],
                    'title' => $rowData[5],
                    'status' => 'active',
                ])->save();

                $post->authors()->syncWithoutDetaching($user->id);
            }
            else {
                $user = User::firstWhere('email', $rowData[2]);
                if (empty($user)) {
                    $user = new User();
                }

                $user->fill([
                    'email' => $rowData[2],
                    'user_type' => 'author',
                    'full_name' => $rowData[1],
                    'role_id' => 0,
                ])->save();

                $post = Post::firstWhere('title', $rowData[5]);
                if (empty($post)) {
                    $post = new Post();
                }
                $post->fill([
                    'paper_id' => $rowData[0],
                    'title' => $rowData[5],
                    'status' => 'active',
                ])->save();

                $post->authors()->syncWithoutDetaching($user->id);
            }


        }
    }
}
