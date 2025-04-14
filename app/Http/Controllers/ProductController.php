<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Catalog;
use App\Models\Review;
use DB;
use App\Models\Discount;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

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


    public function index(Request $request)
    {
        $search = $request->input('search');
        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('ProductName', 'like', "%{$search}%")
                            ->orWhere('Description', 'like', "%{$search}%");
            })
            ->paginate(10);

        $categories = Catalog::all();

        return view('products.index', compact('products', 'categories', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:catalog,CatalogID',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $product = new Product();
        $product->ProductName = $request->name;
        $product->Description = $request->description;
        $product->Price = $request->price;
        $product->Stock = $request->quantity;
        $product->CategoryID = $request->category_id;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('', 'public');
            $product->ImageURL = $imagePath;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được thêm thành công!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if (File::exists(public_path('storage/' . $product->ImageURL))) {
            File::delete(public_path('storage/' . $product->ImageURL));
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được xóa.');
    }

    public function updateStock(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update(['Stock' => $request->stock]);

        return redirect()->route('products.index')->with('success', 'Tồn kho đã được cập nhật.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Catalog::all();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:catalog,CatalogID',
            'image' => 'image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->ImageURL = $imagePath;
        }

        $product->update([
            'ProductName' => $request->name,
            'Description' => $request->description,
            'Price' => $request->price,
            'Stock' => $request->quantity,
            'CategoryID' => $request->category_id,
        ]);

        return redirect()->route('products.index')->with('success', 'Bạn đã thay đổi thành công!');
    }

    public function create()
    {
        $categories = Catalog::all();
        return view('products.create', compact('categories'));
    }
}
