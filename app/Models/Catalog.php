<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    protected $table = 'catalog';
    protected $primaryKey = 'CatalogID'; // Dùng CatalogID vì thống nhất với products table
    public $timestamps = false;

    protected $fillable = ['CatalogID', 'CatalogName'];

    public function products()
    {
        return $this->hasMany(Product::class, 'CategoryID', 'CatalogID'); // Product.CategoryID -> Catalog.CatalogID
    }
}
