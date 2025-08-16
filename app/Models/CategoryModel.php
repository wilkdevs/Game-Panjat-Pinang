<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "categories";

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'active'
    ];
}
