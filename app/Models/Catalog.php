<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\HasFactory;
=======
>>>>>>> c45417a (Resolve merge conflicts after pulling from origin develop)
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
<<<<<<< HEAD
    use HasFactory;

    protected $table = 'catalog'; // Đảm bảo tên bảng là đúng
    protected $primaryKey = 'CatalogID'; // Tên cột khóa chính
    public $timestamps = false;

    protected $fillable = ['CatalogID', 'CatalogName'];

    public function products()
    {
        return $this->hasMany(Product::class, 'CategoryID', 'CatalogID'); // Đảm bảo khóa ngoại đúng
    }
}

