<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    use HasFactory;

    protected $table = "admins";

    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'deleted',
    ];
}
