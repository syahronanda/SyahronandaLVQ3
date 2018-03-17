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
        return view('tes');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'file' => 'required|mimes:txt,csv',
        ]);
        $file = $request->file('file');

        if (isset($file))
        {
            $filename = 'FileEkstrasi.'. $file->getClientOriginalExtension();
            $file->move('upload',$filename);
        }else{
            echo "tidak ada file";
        }
        return redirect()->route('data.index')->with('successMsg','Data Tersimpan');
    }

    public function destroy()
    {

        if (file_exists('upload/FileEkstrasi.txt'))
        {
            unlink('upload/FileEkstrasi.txt');
        }
        return redirect()->back()->with('successMsg','Item successfully Deleted');
    }
}
