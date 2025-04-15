<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use App\Models\Catalog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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

        $reviewed = Review::where('ProductID', $productID)
                      ->where('UserID', Auth::id())
                      ->exists();

        return view('review.form', [
            'product' => $product,
            'back_url' => $backUrl,
            'reviewed' => $reviewed
        ]);
    }
    

    // Lưu đánh giá từ form
   

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,ProductID',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);
    
        $user = Auth::user();
        $userID = $user->UserID;

        $orderExists = DB::table('orders')
        ->join('orderdetails', 'orders.OrderID', '=', 'orderdetails.OrderID')
        ->where('orders.UserID', $userID)
        ->where('orderdetails.ProductID', $request->product_id)
        ->where('orders.StatusOrders', 'Hoàn thành')
        ->exists();

    if (!$orderExists) {
        return redirect()->back()->with('error', 'Bạn chỉ có thể đánh giá sản phẩm sau khi mua và nhận hàng.');
    }
    
        Review::create([
            'ProductID' => $request->product_id,
            'UserID' => $user->UserID, // hoặc Auth::id() nếu đúng cột là UserID
            'Rating' => $request->rating,
            'Comment' => $request->comment,
            'ReviewDate' => now(),
        ]);
    
        return redirect()->route('product.detail', ['id' => $request->product_id])
                         ->with('success', 'Đánh giá đã được gửi!');
    }
    


}
