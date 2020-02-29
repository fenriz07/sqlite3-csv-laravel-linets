<?php

namespace App\Http\Controllers;

use App\Products;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportCsvController extends Controller
{
    
    public function index()
    {
        return ( new ProductsExport )->download('products.csv',\Maatwebsite\Excel\Excel::CSV);
    }
}
