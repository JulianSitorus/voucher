<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher_claim extends Model
{
    use HasFactory;
    protected $table = 'voucher_claims';
    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function voucher()
    {
        return $this->belongsTo('App\Models\Voucher', 'id_voucher');
    }
}
