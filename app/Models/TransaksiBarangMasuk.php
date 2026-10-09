<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiBarangMasuk extends Model
{
    protected $fillable = [
        'id_barang',
        'jumlah',
        'tanggal_masuk'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id');
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'id_gudang', 'id');
    }
}
