<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Catalog;
use App\Models\Review;
class ProductController extends Controller
{

public function show($id)
{
    $product = DB::table('products')
    ->leftJoin('discount', 'products.DiscountID', '=', 'discount.DiscountID')
    ->select('products.*', 'discount.DiscountValue', 'discount.StartDate', 'discount.EndDate')
    ->where('products.ProductID', $id)
    ->first();


    $list_catalog = Catalog::all();

    // Lấy danh sách đánh giá của sản phẩm
    $reviews = Review::where('ProductID', $id)->get();

    return view('product.detail', [
        'product' => $product,
        'list_catalog' => $list_catalog,
        'reviews' => $reviews,
    ]);
}


    

}
