<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    public function index()
    {
        return Buku::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_buku' => 'required|unique:buku',
            'judul_buku' => 'required',
            'kategori_buku' => 'required',
            'stok_buku' => 'required|integer',
            'tahun_buku' => 'required|integer',
        ]);

        return Buku::create($request->all());
    }

    public function show($id)
    {
        return Buku::find($id);
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::find($id);
        $buku->update($request->all());
        return $buku;
    }

    public function destroy($id)
    {
        return Buku::destroy($id);
    }
}

