<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $fillable = ['nama_peminjam', 'alamat_peminjam', 'kontak', 'tanggal_peminjaman', 'tanggal_pengembalian'];

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'peminjam_id');
    }
}

