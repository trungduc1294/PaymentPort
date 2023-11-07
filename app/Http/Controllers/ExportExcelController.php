<?php

namespace App\Http\Controllers;

use App\Exports\ExportFile;
use Maatwebsite\Excel\Facades\Excel;

class ExportExcelController extends Controller
{
    public function index()
    {

    }

    public function export()
    {
        return Excel::download(new ExportFile, 'posts.xlsx');
    }
}
