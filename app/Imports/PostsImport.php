<?php

namespace App\Imports;

use App\Models\ExcelData;
use Maatwebsite\Excel\Concerns\ToModel;

class PostsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ExcelData([
            'post_id' => $row[0],
            'author_name' => $row[1],
            'title' => $row[2],
            'email' => $row[3],
        ]);
    }
}
