<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    protected $fillable = [
        'kode_gudang',
        'nama_gudang',
        'lokasi'
    ];

    public function transaksiBarangMasuk()
    {
        return $this->hasMany(TransaksiBarangMasuk::class, 'id_gudang', 'id');
    }

    

}
