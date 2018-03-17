<?php
/**
 * Copyright (c) 2018. Bobby Syahronanda
 * Name : Bobby Syahronanda., MTA
 * Email  : Bobbysyahronanda@gmail.com
 * Today : 3/15/18 4:46 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class DataController extends Controller
{
    public function index()
    {

        if (file_exists('upload/FileEkstrasi.txt')) {
            //return view('tes');
            //Ambil File Konten
            $file = public_path() . '/upload/FileEkstrasi.txt';
            $contents = \File::get($file);

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
            //print_r($info['data_1']);
            $normalisasi = $this->normalisasiData($info,$jumlahdata);
            $info = $normalisasi;
            return view('tes', compact('info', 'jumlahdata'));
        } else {

        }
        $info[][] = [];
        $jumlahdata = 0;
        return view('tes', compact('info', 'jumlahdata'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:txt,csv',
        ]);
        $file = $request->file('file');

        if (isset($file)) {
            $filename = 'FileEkstrasi.' . $file->getClientOriginalExtension();
            $file->move('upload', $filename);
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
    function decimal2($number)
    {
        return 1 * (number_format((float)$number, 3, '.', ''));
    }


    function norms($x, $min, $max)
    {
        if (($max - $min) == 0) {
            return 0;
        }
        return self::decimal2((($x - $min) / ($max - $min)));
    }


    function normalisasiData($info, $jumlah)
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

}
