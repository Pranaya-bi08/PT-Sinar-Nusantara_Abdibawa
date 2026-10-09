<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = [
        'id_barang',
        'id_pelanggan',
        'jumlah',
        'total_harga',
        'status',
        'dibatalkan_pada',
        'alasan_pembatalan',
    ];

    protected $casts = [
        'dibatalkan_pada' => 'datetime',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id');
    }

    
}
