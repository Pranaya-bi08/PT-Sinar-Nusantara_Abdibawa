<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'sku',
        'nama_barang',
        'kategori',
        'satuan',
        'harga_pokok',
        'harga_jual',
        'status_aktif'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }


    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'barang_id', 'id');
    }
}
