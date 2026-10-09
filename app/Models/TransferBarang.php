<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferBarang extends Model
{
    protected $fillable = [
        'id_barang',
        'id_gudang_asal',
        'id_gudang_tujuan',
        'jumlah'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id');
    }

    public function gudangAsal()
    {
        return $this->belongsTo(Gudang::class, 'id_gudang_asal', 'id');
    }

    public function gudangTujuan()
    {
        return $this->belongsTo(Gudang::class, 'id_gudang_tujuan', 'id');
    }
}
