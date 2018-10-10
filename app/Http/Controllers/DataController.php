<?php
/**
 * Copyright (c) 2018. Bobby Syahronanda
 * Name : Bobby Syahronanda., MTA
 * Email  : Bobbysyahronanda@gmail.com
 * Today : 3/15/18 4:46 PM
 */

namespace App\Http\Controllers;

use App\Hasils;
use App\Infodata;
use Illuminate\Http\Request;


class DataController extends Controller
{
    public function index()
    {
        $data = Infodata::orderBy('nama', 'asc')->get();
        return view('data', compact('data'));
    }

    public function show($tipe)
    {

        $info[][] = [];
        $jumlahdata = 0;

        //$File = Infodata::all()->last();
        $NamaFile = $tipe . '.txt';


        if (file_exists('upload/' . $NamaFile)) {

            //Ambil File Konten
            $file = public_path() . '/upload/' . $NamaFile;
            $jumlahdata = self::GetJumlahCiri($file);
            $info = self::GetDataNormalisasi($file);

            return view('normalisasi', compact('info', 'jumlahdata', 'NamaFile', 'tipe'));
        } else {
            echo "gak ada file";
        }

        return view('normalisasi', compact('info', 'jumlahdata', 'NamaFile'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:txt',
        ]);
        $file = $request->file('file');
        $FILE = Infodata::where('nama', $request->nama)->get()->first();

        if (isset($file)) {
            $ciri = self::GetJumlahCiri($file) - 1;
            $ValidasiFile = self::ValidasiDataEkstrasi($file);
            if ($ValidasiFile == true) {
                if ($FILE == '') {
                    $filename = $request->nama . '.' . $file->getClientOriginalExtension();
                    $file->move('upload', $filename);

                    $data = new Infodata();
                    $data->nama = $request->nama;
                    $data->nama_file = $filename;
                    $data->ciri = $ciri;
                    $data->id_rujukan_pengujian = '0';
                    $data->save();
                    return redirect()->route('data.index')->with('successMsg', 'Data ' . $filename . ' Tersimpan');
                } else {
                    $filename = $request->nama . '.' . $file->getClientOriginalExtension();
                    $file->move('upload', $filename);

                    $FILE->id_rujukan_pengujian = '0';
                    $FILE->ciri = $ciri;
                    $FILE->save();
                    self::HapusHasilUji($request->nama);
                    return redirect()->route('data.index')->with('successMsg', 'Data ' . $filename . ' Terupdate');
                }
            }
            else{
                return redirect()->route('data.index')->with('warningMsg', 'Data File Ekstrasi Tidak Valid');
            }

        } else {
            echo "tidak ada file";
        }


    }

    public function HapusHasilUji($tipe)
    {
        $Hasil = Hasils::where('jnsQolqolah', $tipe)->get();
        foreach ($Hasil as $hasil) {
            $Hapus = Hasils::find($hasil->id);
            $Hapus->delete();
        }
    }

    /*public function destroy()
    {

        if (file_exists('upload/FileEkstrasi.txt')) {
            unlink('upload/FileEkstrasi.txt');
        }
        return redirect()->back()->with('successMsg', 'Item successfully Deleted');
    }*/

    public function SetVektorLatih($jenis, $id)
    {
        $Data = Infodata::where('nama', $jenis)->get()->first();
        $Data->id_rujukan_pengujian = $id;
        $Data->save();
        return redirect()->to('hasil/' . $jenis)->with('successMsg', 'Vektor Latih Terupdate');

    }

    //Bagian Normalisasi
    private function decimal2($number)
    {
        return 1 * (number_format((float)$number, 3, '.', ''));
    }

    private function norms($x, $min, $max)
    {
        if (($max - $min) == 0) {
            return 0;
        }
        return self::decimal2((($x - $min) / ($max - $min)));
    }

    private function normalisasiData($info, $jumlah)
    {
        for ($arr = 0; $arr < count($info['data_0']); $arr++) {
            $no = $arr + 1;


            for ($label = 0; $label < $jumlah - 1; $label++) {
                $norm['data_' . $label][$arr] = self::norms(($info['data_' . $label][$arr]), (min($info['data_' . $label])), (max($info['data_' . $label])));

            }

            if ((fnmatch("*S*", $info['data_' . ($jumlah - 1)][$arr]))) {
                $norm['data_' . ($jumlah - 1)][$arr] = '2';
            } else {
                $norm['data_' . ($jumlah - 1)][$arr] = '1';
            }

        }
        return $norm;
    }

    private function normalisasiSatuData($DataBaru, $DataLama, $jumlah)
    {

        for ($label = 0; $label < $jumlah - 1; $label++) {
            $norm[$label] = self::norms(($DataBaru[$label]), (min($DataLama['data_' . $label])), (max($DataLama['data_' . $label])));
        }
        return $norm;
    }

    private function normalisasiSatuData2($DataBaru, $DataLama, $jumlah)
    {

        $AkhirData = count($DataLama['data_1']);
        for ($lbl = 0; $lbl < $jumlah - 1; $lbl++) {
            $DataLama['data_' . $lbl][$AkhirData] = $DataBaru[$lbl];
        }

        for ($label = 0; $label < $jumlah - 1; $label++) {
            $norm[$label] = self::norms(($DataBaru[$label]), (min($DataLama['data_' . $label])), (max($DataLama['data_' . $label])));
        }
        return $norm;
    }

    //Konversi File Ke Array
    private function FileToArray($contents)
    {
        //Ubha Data Menjadi Array
        $rows = explode("\n", $contents);
        $i = 0;
        $row_data_ = explode(',', $rows[0]);
        $jumlahdata = count($row_data_);

        foreach ($rows as $row => $data) {
            //get row data
            $row_data = explode(',', $data);
            if (isset($row_data[$jumlahdata - 1])) {

            } else {
                continue;
            }
            for ($label = 0; $label <= $jumlahdata - 1; $label++) {
                $info['data_' . $label][$i] = $row_data[$label];
            }
            $i++;
        }
        return $info;
    }

    //fungsi untuk pengambilan data
    public function GetJumlahCiri($file)
    {
        //Ubha Data Menjadi Array
        $contents = \File::get($file);
        $rows = explode("\n", $contents);
        $i = 0;
        $row_data_ = explode(',', $rows[0]);
        return $jumlahdata = count($row_data_);

    }

    public function GetDataNormalisasi($file)
    {
        $contents = \File::get($file);
        $jumlahdata = self::GetJumlahCiri($file);
        $info = self::FileToArray($contents);

        $normalisasi = $this->normalisasiData($info, $jumlahdata);
        return $info = $normalisasi;
    }

    public function GetSatuDataNormalisasi($DataBaru, $file)
    {
        $contents = \File::get($file);
        $jumlahdata = self::GetJumlahCiri($file);
        $info = self::FileToArray($contents);

        $normalisasi = $this->normalisasiSatuData2($DataBaru, $info, $jumlahdata);
        return $normalisasi;
    }

    public function GetData($data, $jumlahciri, $batasAwal, $batasAkhir, $jenisData)
    {
        $totaldata = count($data['data_0']);
        $i = 0;
        $tr0 = $batasAwal;
        $tr1 = $batasAkhir;
        $view = $data;


        while ($i < $totaldata) {

            if (($i > $tr0 - 1) && ($i < $tr1 + 1)) {
                for ($j = 1; $j < $jumlahciri; $j++) {
                    $datauji[$j][$i] = $view['data_' . ($j - 1)][$i];
                }
                $datauji[0][$i] = $view['data_' . ($j - 1)][$i];

            } else {
                for ($j = 1; $j < $jumlahciri; $j++) {
                    $datalatih[$j][$i] = $view['data_' . ($j - 1)][$i];
                }
                $datalatih[0][$i] = $view['data_' . ($j - 1)][$i];
            }
            $i++;
        }
        if ($jenisData == 'Uji') {
            return $datauji;
        } else {
            return $datalatih;
        }

    }

    public function ValidasiDataEkstrasi($file)
    {
        $contents = \File::get($file);

        //Ubha Data Menjadi Array
        $rows = explode("\n", $contents);
        $row_data_ = explode(',', $rows[0]);
        $jumlahCiri = count($row_data_);
        $jumlahData = count($rows);

        $no = 0;
        $kondisi = true;
        foreach ($rows as $row) {
            $data = explode(',', $rows[$no]);
            $ciri = count($data);
            $status = $data[$ciri - 1];
            $no++;
            //echo $no++."Ciri = ".$ciri." -> status ".$status." <br>";
            if (fnmatch("*B*", $status) || fnmatch("*S*", $status)) {
                $kondisiStatus = "n";
            } else {
                $kondisiStatus = "x";
            }

            if ($ciri != $jumlahCiri || $kondisiStatus == "x") {
                $kondisi = false;
                break;
            }
        }
        return $kondisi;
    }
}
