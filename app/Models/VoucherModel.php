<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\GiftModel;

class VoucherModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "vouchers";

    public $incrementing = false;

    protected $fillable = [
        'id',
        'gift_id',
        'code',
        'name',
        'info',
        'status',
        'active',
    ];

    public function gift()
    {
        return $this->belongsTo(GiftModel::class, 'gift_id')->withTrashed();
    }
}
