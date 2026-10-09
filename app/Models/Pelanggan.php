<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = [
        'nama_pelanggan',
        'alamat',
        'no_hp'
    ];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_pelanggan', 'id');
    }
}
