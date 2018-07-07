<?php

namespace App\Http\Controllers;

use App\Hasils;
use App\Infodata;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    //
    public function index()
    {
        $data = Infodata::orderBy('nama', 'asc')->get();
        return view('hasil', compact('data'));
    }

    public function show($tipe)
    {
        $data = Hasils::where('jnsQolqolah', $tipe)->orderBy('akurasiRataRata', 'desc')->get();
        $DataQolqolah = Infodata::where('nama', $tipe)->get()->first();
        $idRujukan = $DataQolqolah->id_rujukan_pengujian;
        return view('jenishasil', compact('data', 'tipe', 'idRujukan'));
    }

    public function Detail($tipe,$id)
    {
        $Data = Hasils::find($id);

        $alfa = $Data->alfa;
        $window = $Data->window;
        $kfold = $Data->kfold;
        return view('detailhasil', compact('alfa', 'window', 'kfold','tipe'));
    }
}
