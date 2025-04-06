<?php

// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $catalogID = $request->get('catalog');
        $page = $request->get('page', 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;

        // Danh mục
        $list_catalog = DB::table('catalog')->get();

        // Sản phẩm
        if (!empty($catalogID)) {
            $products = DB::table('products')
                ->where('CategoryID', $catalogID)
                ->limit($limit)
                ->offset($offset)
                ->get();

            $total_products = DB::table('products')
                ->where('CategoryID', $catalogID)
                ->count();
        } else {
            $products = DB::table('products')
                ->orderBy('Price', 'desc')
                ->limit($limit)
                ->offset($offset)
                ->get();

            $total_products = DB::table('products')->count();
        }

        $total_pages = ceil($total_products / $limit);

        return view('home.index', compact('list_catalog', 'products', 'catalogID', 'page', 'total_pages'));
    }
    public function search(Request $request)
    {
        $keyword = $request->input('search');

        $products = DB::table('products')
            ->where('ProductName', 'LIKE', '%' . $keyword . '%')
            ->paginate(10);

        $list_catalog = DB::table('catalog')->get();

        return view('home.index', [
            'products' => $products,
            'list_catalog' => $list_catalog,
            'catalogID' => null,
            'page' => $products->currentPage(),
            'total_pages' => $products->lastPage()
        ]);
}

}
