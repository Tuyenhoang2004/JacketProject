<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    protected $table = 'catalog';
    protected $primaryKey = 'CategoryID';
    public $timestamps = false;
}

