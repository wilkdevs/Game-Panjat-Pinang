<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryModel;

class GiftModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "gifts";

    public $incrementing = false;

    protected $fillable = [
        'id',
        'category_id',
        'name',
        'image',
        'probability',
        'active',
    ];

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }
}
