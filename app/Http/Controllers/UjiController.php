<?php

namespace App\Http\Controllers;

use App\Formula\Lvq;
use App\Hasils;
use App\Infodata;
use Illuminate\Http\Request;

class UjiController extends Controller
{
    //
    public function index()
    {
        $data = Infodata::orderBy('nama', 'asc')->get();
        return view('uji', compact('data'));
    }

    public function show($tipe)
    {
        return view('prosesUji', compact('tipe'));
    }

    public function store(Request $request)
    {
        $DataQolqolah = Infodata::where('nama', $request->tipe)->get()->first();
        $DataVektorUji = Hasils::find($DataQolqolah->id_rujukan_pengujian);
        $tipe = $request->tipe;
        $DataUji = explode(',', $request->ciri);
        $file = public_path() . '/upload/' . $request->tipe . '.txt';

        if (count($DataUji) == $DataQolqolah->ciri) {
            $Normalisasi = new DataController();
            $DataBaru = $Normalisasi->GetSatuDataNormalisasi($DataUji, $file);
            $W1 = explode(',', $DataVektorUji->vektor1);
            $W2 = explode(',', $DataVektorUji->vektor2);

            $Data = self::SetArrayDari1($DataBaru);
            $V1 = self::SetArrayDari1($W1);
            $V2 = self::SetArrayDari1($W2);

            $LVQ3 = new Lvq();
            //Pengujian
            $D1 = $LVQ3->hitungVector($Data, $V1);
            $D2 = $LVQ3->hitungVector($Data, $V2);

            //Hitung Min
            $Hasil = $LVQ3->hitungVMin($D1, $D2);

            //echo "<br> Hasil Perbandingan = ".$Hasil;

            $DataView['DataUji'] = $request->ciri;
            $DataView['DataV1'] = $DataVektorUji->vektor1;
            $DataView['DataV2'] = $DataVektorUji->vektor2;
            $DataView['V1'] = $D1;
            $DataView['V2'] = $D2;
            $DataView['Hasil'] = $Hasil;


            return view('hasilPengujianTunggal', compact('DataView','tipe'));

        } else {
            return redirect()->to('uji/'.$tipe)->with('warningMsg', 'Data Input Salah Atau Ciri Tidak Cocok');
        }

    }

    private function SetArrayDari1($data)
    {
        $array[0] = "";
        for ($i = 1; $i <= count($data); $i++) {
            $array[$i] = $data[$i - 1];
        }
        return $array;
    }
}
