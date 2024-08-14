<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $table = 'vouchers';
    // protected $fillable = ['nama_karyawan','departemen','unit','posisi','status'];
    protected $guarded=[];

    public function voucher_claim()
    {
        return $this->hasMany('App\Models\Voucher_claim', 'id_voucher');
    }

}
