<?php

namespace App\Http\Controllers;
use App\Exports\ProductoExport;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function productoXLS(){

        return Excel::download(new ProductoExport, 'users.xlsx');

    }
}
