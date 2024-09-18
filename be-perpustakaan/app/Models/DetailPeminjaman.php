<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    protected $table = 'detail_peminjaman';
    protected $fillable = ['buku_id', 'peminjam_id'];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjam_id');
    }
}
