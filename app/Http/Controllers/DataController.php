<?php
/**
 * Copyright (c) 2018. Bobby Syahronanda
 * Name : Bobby Syahronanda., MTA
 * Email  : Bobbysyahronanda@gmail.com
 * Today : 3/15/18 4:46 PM
 */

namespace App\Http\Controllers;

use App\Infodata;
use Illuminate\Http\Request;


class DataController extends Controller
{
    public function index()
    {
        $data = Infodata::all();
        return view('data', compact('data'));
    }

    public function detail()
    {
        $info[][] = [];
        $jumlahdata = 0;

        $File = Infodata::all()->last();
        $NamaFile = $File->nama_file;


        if (file_exists('upload/'.$NamaFile)) {

            //Ambil File Konten
            $file = public_path() . '/upload/'.$NamaFile;
            $jumlahdata = self::GetJumlahCiri($file);
            $info = self::GetDataNormalisasi($file);

            return view('data', compact('info', 'jumlahdata','NamaFile'));
        } else {
            echo "gak ada file";
        }

        return view('data', compact('info', 'jumlahdata','NamaFile'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:txt',
        ]);
        $file = $request->file('file');

        if (isset($file)) {
            $filename = $request->nama.'.' . $file->getClientOriginalExtension();
            $file->move('upload', $filename);

            $data = new Infodata();
            $data->nama = $request->nama;
            $data->nama_file = $filename;
            $data->save();
        } else {
            echo "tidak ada file";
        }

        return redirect()->route('data.index')->with('successMsg', 'Data Tersimpan');
    }

    public function destroy()
    {

        if (file_exists('upload/FileEkstrasi.txt')) {
            unlink('upload/FileEkstrasi.txt');
        }
        return redirect()->back()->with('successMsg', 'Item successfully Deleted');
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

            if ((fnmatch("*O*", $info['data_' . ($jumlah - 1)][$arr]))) {
                $norm['data_' . ($jumlah - 1)][$arr] = '2';
            } else {
                $norm['data_' . ($jumlah - 1)][$arr] = '1';
            }

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

        $normalisasi = $this->normalisasiData($info,$jumlahdata);
        return $info = $normalisasi;
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

}
