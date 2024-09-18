<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $fillable = ['kode_buku', 'judul_buku', 'kategori_buku', 'stok_buku', 'tahun_buku'];

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'buku_id');
    }
}
