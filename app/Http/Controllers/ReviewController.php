<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use App\Models\Catalog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReviewController extends Controller
{
    // Hiển thị form đánh giá sản phẩm
    public function create(Request $request)
    {
        $list_catalog = DB::table('catalog')->get();
        $productID = $request->query('ProductID');
        $backUrl = $request->query('back_url', route('home'));

        $product = Product::where('ProductID', $productID)->first();

        if (!$product) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
        }

        return view('review.form', [
            'product' => $product,
            'back_url' => $backUrl
        ]);
    }

    // Lưu đánh giá từ form
    public function store(Request $request)
    {
        $list_catalog = Catalog::all();
        $request->validate([
            'product_id' => 'required|exists:products,ProductID',
            'user_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = new Review();
        $review->ProductID = $request->input('product_id');
        $review->UserName = $request->input('user_name');
        $review->Rating = $request->input('rating');
        $review->Comment = $request->input('comment');
        $review->ReviewDate = now();
        $review->save();

        return redirect($request->input('back_url', route('home')))
               ->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
}
