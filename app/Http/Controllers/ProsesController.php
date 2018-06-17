<?php

namespace App\Http\Controllers;

use App\Hasils;
use Illuminate\Http\Request;
use App\Http\Controllers\DataController;
use App\Formula\Lvq;
use App\Formula\Window;

class ProsesController extends Controller
{

    function index()
    {
        return view('proses');
    }

    public function store2(Request $request)
    {
        //request
        $NilaiAlfa = $request->alfa;
        $NilaiWindow = $request->window;
        $NilaiKFold = $request->kfold;


        //variabel internal

        $AkurasiAkhir = 0;
        $PengujianTerbaik = 0;
        $W1Akhir[] = null;
        $W2Akhir[] = null;
        $TotalAkurasi = 0;

        $i = 0;

        $nol = 0;


        $i = $nol;
        $kfold = $NilaiKFold;


        $batasawal = 108;
        $batasakhir = 119;

        //inisialisisi formula
        $lvq = new Lvq();
        $Window = new Window();

        $file = public_path() . '/upload/' . $request->namafile . '.txt';

        $Normalisasi = new DataController();
        $jumlahciri = $Normalisasi->GetJumlahCiri($file);
        $dataNormalisasi = $Normalisasi->GetDataNormalisasi($file);
        //print_r($data);

        $totalData = count($dataNormalisasi['data_0']);
        $bagi = ($totalData / $kfold);
        //perulangan k fold
        $perulanganKfold = 0;
        for ($tr0 = 0; $tr0 < $totalData; $tr0 = $tr0 + $bagi) {
            //deklarasi koefesion matrix
            $ww1 = $ww2 = $nol;
            $SUMYp1 = 0;
            $SUMTp1 = 0;
            $SUMYp2 = 0;
            $SUMTp2 = 0;
            $SUMYp = 0;
            $SUMTp = 0;
            $a = $alfa = $NilaiAlfa;
            $e = $window = $NilaiWindow;
            $epoch = 1;
            $setWW1 = false;
            $setWW2 = false;
            $batasawal = $tr0;
            $batasakhir = $tr0 + ($bagi - 1);
            echo "ambil data dimulai dari " . $batasawal . "-" . $batasakhir;
            echo "<br>";
            $perulanganKfold++;


            $data = $Normalisasi->GetData($dataNormalisasi, $jumlahciri, $batasawal, $batasakhir, 'Latih');
            $datauji = $Normalisasi->GetData($dataNormalisasi, $jumlahciri, $batasawal, $batasakhir, 'Uji');

            //print_r($data);
            // exit();
            echo "<strong><h1>PELATIHAN " . $perulanganKfold . "</h1></strong>";


            for ($i = 0; $i < (count($dataNormalisasi['data_0'])); $i++) {

                if (($i >= $batasawal) && ($i <= $batasakhir)) {
                    continue;
                } else {

                    if ($setWW1 == false) {
                        if ($data[0][$i] == 1) {
                            echo "ketemu data W1 " . $i;
                            echo "<br>";
                            echo $data[0][$i];
                            $setWW1 = true;
                            $ww1 = $i;
                        }
                    }

                    if ($setWW2 == false) {
                        if ($data[0][$i] == 2) {
                            echo "ketemu data W2 " . $i;
                            echo "<br>";
                            echo $data[0][$i];
                            $setWW2 = true;
                            $ww2 = $i;
                        }
                    }

                    if ($setWW1 == true && $setWW2 == true) {
                        break;
                    }
                }

            }


            echo " <br>for ke" . $i . "<br>";

            echo 'data adalah ' . $ww1 . ' dan ' . $ww2 . "<br>";

            //print_r($data);
            for ($i = 0; $i < $jumlahciri; $i++) {
                $W1[$i] = $data[$i][$ww1];
                $W2[$i] = $data[$i][$ww2];
            }


            //Echo weight awal
            echo "W1 Awal :";
            print_r($W1);
            echo "<br>";
            echo "<br>";
            echo "W2 Awal :";
            print_r($W2);
            echo "<br>";
            echo "<br>";


            echo "W1 Awal :";
            $lvq->showVector($W1);
            echo "W2 Awal :";
            $lvq->showVector($W2);


            $bagi = $totalData / $kfold;

            echo "<br> Count Data : " . (count($data[0]) + $bagi) . "<br>";
            //Mulai Loop EPOCH

            while (($epoch < 50)) {
                //min alfa
                if ($a < 0.02) {
                    break;
                }

                //MulaiLoop1Tabeldata
                for ($b = 0; $b < (count($data[0]) + $bagi); $b++) {

                    if (($b >= $batasawal) && ($b <= $batasakhir)) {
                        continue;
                    } else {
                        //khusus testing

                        if ($b == $ww1 || $b == $ww2) {
                            continue;
                        } else {

                            $k = $b;

                            //define X Output
                            for ($i = 0; $i < count($data); $i++) {
                                $x[$i] = $data[$i][$k];

                            } // $x= array(1,0.335,0,1,0,0,0.5,1,0,0.468); //T ny 1?

                            //hitung vektor-vektor
                            $D1 = $lvq->hitungVector($x, $W1);
                            $D2 = $lvq->hitungVector($x, $W2);

                            //Pemenang dan runner up pertama(a) atau kedua(b), out:[1,2]
                            $Ca = $lvq->hitungVMin_2($D1, $D2)[0];

                            //vector kelas menang
                            $J = $Ca;

                            //define vektor pemenang dan runnerup Da|(pemenang) dan Db|(Runnerup)
                            if ($J == 1) {
                                $Da = $D1;
                                $Db = $D2;
                            } else {
                                $Da = $D2;
                                $Db = $D1;
                            }

                            //hitng kecocokan kelas output
                            $sama = $lvq->cekOutput($J, $x[0]); //T=X_[0] ny

                            $masukIf = "";

                            if ($sama == "ya") {        //T=C1_ya
                                $masukIf = "didekatkan vektor<br>";
                                if ($J == 1) {
                                    $W1 = $lvq->updateTambah1($x, $W1, $a);  //(+)
                                } else {
                                    $W2 = $lvq->updateTambah1($x, $W2, $a);  //(+)
                                }
                            } else {                    //T=C1_tidak
                                //defined jarak terkecil:sudah, diatas
                                if ($Window->cekWindow3($Da, $Db, $e) == "true") {    //deteksi windows
                                    $masukIf = "masuk window<br>";
                                    // if(){} bypass??

                                    if ($J == 1) {
                                        $W1 = $lvq->updateKurang1($x, $W1, $a); //(-)
                                        $W2 = $lvq->updateTambah1($x, $W2, $a); //(+)
                                    } else {
                                        $W2 = $lvq->updateKurang1($x, $W2, $a); //(-)
                                        $W1 = $lvq->updateTambah1($x, $W1, $a); //(+)
                                    }


                                } else {
                                    $masukIf = "dijauhi vektor<br>";
                                    if ($J == 1) {
                                        $W1 = $lvq->updateKurang1($x, $W1, $a); //(-)
                                    } else {
                                        $W2 = $lvq->updateKurang1($x, $W2, $a); //(-)
                                    }
                                }
                            }
                            //AKHIR SATU DATA_____________________

                        }
                    }
                }
                $epoch++;
                $a = $a - (0.1 * $a);

            }//END OF TRAINING CODE

            echo "</br>";
            echo "Epoch = " . $epoch;
            echo "</br>";
            echo "Selesai untuk " . count($data[0]) . " data latih";

            //Memulai Pengujian
            echo "<strong><h1>PENGUJIAN " . $perulanganKfold . "</h1></strong>" . "<br>";
            //Echo weight akhir
            echo "W1 akhir= ";
            $lvq->showVector($W1);
            echo "<br>";
            echo "W2 akhir= ";
            $lvq->showVector($W2);
            echo "<br>";

//exit();

//bagian pengujian
            echo "                                                                        
                        </tbody>
                    </table>
                    </div>
					
					
	
 <br><br>
                    <div class='box-body'>
                    <table id='viewTabel' class='table table-bordered table-striped table-hover'>
                        <thead style='background-color:#6bfc19'>
                            <tr>
								 <th>Data ke</th>
                                <th>Kelas Input</th>
                                <th>Hitng Vektor D1</th>
                                <th>Hitng Vektor D2</th>
                                <th>Kelas Prediksi</th>
                                <th>Kelas Output<br>(sama)</th>
                                <th>Update W1</th>
                                <th>Update W2</th>
                                <th>Ket.</th>
                               
                            </tr>
                        </thead>
                        <tbody>           				
                ";
            //MulaiLoop1Tabel_____________________________________________________________
            $W1_ = $W1;
            $W2_ = $W2;
            $Yp = $Tp = $nol;
            $Yp1 = $Tp1 = $Yp2 = $Tp2 = $nol;
            for ($b_ = $batasawal; $b_ < (count($datauji[0]) + $batasawal); $b_++) {


                $k_ = $b_;
                echo "<tr><td><strong>no " . ($k_ + 1) . "</strong><br></td>"; //judul

                //define X Output
                for ($i_ = 0; $i_ < count($datauji); $i_++) {
                    $x_[$i_] = $datauji[$i_][$k_];


                } // $x_= array(1,0.335,0,1,0,0,0.5,1,0,0.468); //T ny 1?


                //print_r ($W1_); echo "<br>";

                echo "<td>x= ";
                $lvq->showVector($x_);
                echo "</td>";
                // exit();
                // echo "W1 = ";
                // showVector($W1_);
                // echo "W2 = ";
                // showVector($W2_);

                //vector terkecil pemenang / J
                $D1_ = $lvq->hitungVector($x_, $W1_);
                $D2_ = $lvq->hitungVector($x_, $W2_);
                echo "<td>";
                echo $D1_;
                echo "<br></td>";
                echo "<td>";
                echo $D2_;
                echo "<br></td>";

                //vector kelas menang
                $J_ = $lvq->hitungVMin($D1_, $D2_);

                echo "<td>[";
                echo $J_;
                echo "]<br></td>"; //J nya


                //hitng kecocokan kelas output
                $sama_ = $lvq->cekOutput($J_, $x_[0]); //T=X_[0] ny
                //$sama="ya"; //hacktes

                echo "<td> <strong>";
                echo $sama_; //ya atau tidak per"sama"an kelas output nya
                echo "</strong></td>";

                //count ya/tidak
                if ($sama_ == "ya") {
                    $Yp = $Yp + 1;
                }
                if ($sama_ == "tidak") {
                    $Tp = $Tp + 1;
                }

                //count ya/tidak kelas sama
                if ($sama_ == "ya") {
                    if ($x_[0] == 1) {
                        $Yp1 = $Yp1 + 1;
                    } else {
                        //if($x_[0]==2){
                        $Yp2 = $Yp2 + 1;
                    }

                } else {
                    if ($sama_ == "tidak") {
                        if ($x_[0] == 1) {
                            $Tp2 = $Tp2 + 1;
                        } else {
                            //if($x_[0]==2){
                            $Tp1 = $Tp1 + 1;
                        }
                    }
                }


                echo "<td>W1= ";
                $lvq->showVector($W1_);
                echo "</td><td>W2= ";
                $lvq->showVector($W2_);
                echo "</td>";
                //AKHIR SATU DATA_____________________


            }
            echo "</tr></tr>
	    </tbody>
                    </table>
                    </div>";

            $centYp = 100 * $Yp / ($Yp + $Tp);
            $centTp = 100 * $Tp / ($Yp + $Tp);
            echo "Ya, Sama= " . $centYp . "% |" . $Yp;
            echo "<br>";

            echo "Tidak sama= " . $centTp . "% |" . $Tp;
            echo "<br>";

            $centYp1 = 100 * $Yp1 / ($Yp + $Tp);
            $centTp1 = 100 * $Tp1 / ($Yp + $Tp);
            $centYp2 = 100 * $Yp2 / ($Yp + $Tp);
            $centTp2 = 100 * $Tp2 / ($Yp + $Tp);

//sum works
            $SUMYp1 += $Yp1;
            $SUMTp1 += $Tp1;
            $SUMYp2 += $Yp2;
            $SUMTp2 += $Tp2;
            $SUMYp += $Yp;
            $SUMTp += $Tp;


            echo " <table id='viewTabel' class='table table-bordered table-striped table-hover'>
                        <thead style='background-color:#76B9FC'>";
            echo "<tr>";
            echo "<th></th>";
            echo "<th>Actual 1</th>";
            echo "<th>Actual 2</th>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><b>Predicted 1</b></td>";

            echo "<td>" . $centYp1 . "% |-|" . $Yp1 . "</td>";
            echo "<td>" . $centTp1 . "% ||" . $Tp1 . "</td>";

            echo "</tr>";
            echo "<tr>";
            echo "<td><b>Predicted 2</b></td>";
            echo "<td>" . $centTp2 . "% |-|" . $Tp2 . "</td>";
            echo "<td>" . $centYp2 . "% ||" . $Yp2 . "</td>";

            echo "</tr>";

            echo "</table> <br>";


            if ($centYp >= $AkurasiAkhir) {
                $AkurasiAkhir = $centYp;
                $PengujianTerbaik = $perulanganKfold;
                $W1Akhir = $W1;
                $W2Akhir = $W2;
                $EpochAkhir = $epoch;
                echo " <br> Akurasi Lebih Besar Dari Sebelumnya <br>";
            } else {
                echo " <br> Akurasi Lebih Kecil Dari Sebelumnya <br>";
            }
            $TotalAkurasi = $TotalAkurasi + $centYp;


        }

        echo "end";
        echo "</br>";
        //print_r($data);
        echo "</br>";
//__
        echo "<strong><h1>HASIL AKHIR, AKURASI TERBAIK ADALAH " . $AkurasiAkhir . "% PADA PENGUJIAN KE " . $PengujianTerbaik . ". Rata-rata akurasi = " . ($TotalAkurasi / $kfold) . " % </h1></strong>";
        $W1__ = $lvq->showVector__Kelas($W1Akhir);
        echo "</br>";
        echo "</br>";
        $W2__ = $lvq->showVector__Kelas($W2Akhir);


        //exit();
        $TotalDataUji = count($datauji[0]);
        $TotalDataLatih = count($data[0]);

        //simpan data
        $DataHasil = new Hasils();
        $DataHasil->jnsQolqolah = $request->namafile;
        $DataHasil->totalData = $totalData;
        $DataHasil->totalDataLatih = $TotalDataLatih;
        $DataHasil->totalDataUji = $TotalDataUji;
        $DataHasil->alfa = $request->alfa;
        $DataHasil->window = $request->window;
        $DataHasil->kfold = $request->kfold;
        $DataHasil->epoch = $EpochAkhir;
        $DataHasil->pengujianTerbaik = $PengujianTerbaik;
        $DataHasil->akurasiTerbaik = $AkurasiAkhir;
        $DataHasil->akurasiRataRata = $TotalAkurasi / $kfold;
        $DataHasil->vektor1 = $W1__;
        $DataHasil->vektor2 = $W2__;
        $DataHasil->save();

    }

    public static function tes($ALFA, $WINDOW, $KFOLD)
    {
        //request
        $NilaiAlfa = $ALFA;
        $NilaiWindow = $WINDOW;
        $NilaiKFold = $KFOLD;


        //variabel internal

        $AkurasiAkhir = 0;
        $PengujianTerbaik = 0;
        $W1Akhir[] = null;
        $W2Akhir[] = null;

        $i = 0;

        $nol = 0;


        $i = $nol;
        $kfold = $NilaiKFold;


        $batasawal = 108;
        $batasakhir = 119;

        //inisialisisi formula
        $lvq = new Lvq();
        $Window = new Window();

        $file = public_path() . '/upload/ba_sughro.txt';

        $Normalisasi = new DataController();
        $jumlahciri = $Normalisasi->GetJumlahCiri($file);
        $dataNormalisasi = $Normalisasi->GetDataNormalisasi($file);
        //print_r($data);

        $totalData = count($dataNormalisasi['data_0']);
        $bagi = ($totalData / $kfold);
        //perulangan k fold
        $perulanganKfold = 0;
        for ($tr0 = 0; $tr0 < $totalData; $tr0 = $tr0 + $bagi) {
            //deklarasi koefesion matrix
            $ww1 = $ww2 = $nol;
            $SUMYp1 = 0;
            $SUMTp1 = 0;
            $SUMYp2 = 0;
            $SUMTp2 = 0;
            $SUMYp = 0;
            $SUMTp = 0;
            $a = $alfa = $NilaiAlfa;
            $e = $window = $NilaiWindow;
            $epoch = 1;
            $setWW1 = false;
            $setWW2 = false;
            $batasawal = $tr0;
            $batasakhir = $tr0 + ($bagi - 1);
            $perulanganKfold++;


            $data = $Normalisasi->GetData($dataNormalisasi, $jumlahciri, $batasawal, $batasakhir, 'Latih');
            $datauji = $Normalisasi->GetData($dataNormalisasi, $jumlahciri, $batasawal, $batasakhir, 'Uji');

            //print_r($data);
            // exit();
            echo "<strong><h3>PELATIHAN " . $perulanganKfold . "</h3></strong>";


            for ($i = 0; $i < (count($dataNormalisasi['data_0'])); $i++) {

                if (($i >= $batasawal) && ($i <= $batasakhir)) {
                    continue;
                } else {

                    if ($setWW1 == false) {
                        if ($data[0][$i] == 1) {
                            echo "ketemu data W1 " . $i;
                            echo "<br>";
                            echo $data[0][$i];
                            $setWW1 = true;
                            $ww1 = $i;
                        }
                    }

                    if ($setWW2 == false) {
                        if ($data[0][$i] == 2) {
                            echo "ketemu data W2 " . $i;
                            echo "<br>";
                            echo $data[0][$i];
                            $setWW2 = true;
                            $ww2 = $i;
                        }
                    }

                    if ($setWW1 == true && $setWW2 == true) {
                        break;
                    }
                }

            }


            echo " <br>for ke" . $i . "<br>";

            echo 'data adalah ' . $ww1 . ' dan ' . $ww2 . "<br>";

            //print_r($data);
            for ($i = 0; $i < $jumlahciri; $i++) {
                $W1[$i] = $data[$i][$ww1];
                $W2[$i] = $data[$i][$ww2];
            }


            //Echo weight awal
            echo "W1 Awal :";
            print_r($W1);
            echo "<br>";
            echo "<br>";
            echo "W2 Awal :";
            print_r($W2);
            echo "<br>";
            echo "<br>";


            echo "W1 Awal :";
            $lvq->showVector($W1);
            echo "W2 Awal :";
            $lvq->showVector($W2);


            $bagi = $totalData / $kfold;

            echo "<br> Count Data : " . (count($data[0]) + $bagi) . "<br>";
            //Mulai Loop EPOCH

            while (($epoch < 50)) {
                //min alfa
                if ($a < 0.02) {
                    break;
                }

                //MulaiLoop1Tabeldata
                for ($b = 0; $b < (count($data[0]) + $bagi); $b++) {

                    if (($b >= $batasawal) && ($b <= $batasakhir)) {
                        continue;
                    } else {
                        //khusus testing

                        if ($b == $ww1 || $b == $ww2) {
                            continue;
                        } else {

                            $k = $b;

                            //define X Output
                            for ($i = 0; $i < count($data); $i++) {
                                $x[$i] = $data[$i][$k];

                            } // $x= array(1,0.335,0,1,0,0,0.5,1,0,0.468); //T ny 1?

                            //hitung vektor-vektor
                            $D1 = $lvq->hitungVector($x, $W1);
                            $D2 = $lvq->hitungVector($x, $W2);

                            //Pemenang dan runner up pertama(a) atau kedua(b), out:[1,2]
                            $Ca = $lvq->hitungVMin_2($D1, $D2)[0];

                            //vector kelas menang
                            $J = $Ca;

                            //define vektor pemenang dan runnerup Da|(pemenang) dan Db|(Runnerup)
                            if ($J == 1) {
                                $Da = $D1;
                                $Db = $D2;
                            } else {
                                $Da = $D2;
                                $Db = $D1;
                            }

                            //hitng kecocokan kelas output
                            $sama = $lvq->cekOutput($J, $x[0]); //T=X_[0] ny

                            $masukIf = "";

                            if ($sama == "ya") {        //T=C1_ya
                                $masukIf = "didekatkan vektor<br>";
                                if ($J == 1) {
                                    $W1 = $lvq->updateTambah1($x, $W1, $a);  //(+)
                                } else {
                                    $W2 = $lvq->updateTambah1($x, $W2, $a);  //(+)
                                }
                            } else {                    //T=C1_tidak
                                //defined jarak terkecil:sudah, diatas
                                if ($Window->cekWindow3($Da, $Db, $e) == "true") {    //deteksi windows
                                    $masukIf = "masuk window<br>";
                                    // if(){} bypass??

                                    if ($J == 1) {
                                        $W1 = $lvq->updateKurang1($x, $W1, $a); //(-)
                                        $W2 = $lvq->updateTambah1($x, $W2, $a); //(+)
                                    } else {
                                        $W2 = $lvq->updateKurang1($x, $W2, $a); //(-)
                                        $W1 = $lvq->updateTambah1($x, $W1, $a); //(+)
                                    }


                                } else {
                                    $masukIf = "dijauhi vektor<br>";
                                    if ($J == 1) {
                                        $W1 = $lvq->updateKurang1($x, $W1, $a); //(-)
                                    } else {
                                        $W2 = $lvq->updateKurang1($x, $W2, $a); //(-)
                                    }
                                }
                            }
                            //AKHIR SATU DATA_____________________

                        }
                    }
                }
                $epoch++;
                $a = $a - (0.1 * $a);

            }//END OF TRAINING CODE

            echo "</br>";
            echo "Epoch = " . $epoch;
            echo "</br>";
            echo "Selesai untuk " . count($data[0]) . " data latih";
            echo "</br>";
            //Memulai Pengujian
            echo "<strong><h3>PENGUJIAN " . $perulanganKfold . "</h3></strong>" . "<br>";
            echo "ambil data dimulai dari " . ($batasawal+1) . "-" . ($batasakhir+1);
            echo "<br>";
            //Echo weight akhir
            echo "W1 akhir= ";
            $lvq->showVector($W1);
            echo "<br>";
            echo "W2 akhir= ";
            $lvq->showVector($W2);
            echo "<br>";

//exit();

//bagian pengujian
            echo "                                                                        
                        <br>
                    <div class='box-body'>
                    <table id='viewTabel' class='table table-bordered table-striped table-hover'>
                        <thead style='background-color:#6bfc19'>
                            <tr>
								 <th>Data ke</th>
                                <th>Kelas Input</th>
                                <th>Hitng Vektor D1</th>
                                <th>Hitng Vektor D2</th>
                                <th>Kelas Prediksi</th>
                                <th>Kelas Output<br>(sama)</th>
                                <!--<th>Update W1</th>
                                <th>Update W2</th>
                                <th>Ket.</th>-->
                               
                            </tr>
                        </thead>
                        <tbody>           				
                ";
            //MulaiLoop1Tabel_____________________________________________________________
            $W1_ = $W1;
            $W2_ = $W2;
            $Yp = $Tp = $nol;
            $Yp1 = $Tp1 = $Yp2 = $Tp2 = $nol;
            for ($b_ = $batasawal; $b_ < (count($datauji[0]) + $batasawal); $b_++) {


                $k_ = $b_;
                echo "<tr><td><strong>" . ($k_ + 1) . "</strong><br></td>"; //judul

                //define X Output
                for ($i_ = 0; $i_ < count($datauji); $i_++) {
                    $x_[$i_] = $datauji[$i_][$k_];


                } // $x_= array(1,0.335,0,1,0,0,0.5,1,0,0.468); //T ny 1?


                //print_r ($W1_); echo "<br>";

                echo "<td>x= ";
                $lvq->showVector($x_);
                echo "</td>";
                // exit();
                // echo "W1 = ";
                // showVector($W1_);
                // echo "W2 = ";
                // showVector($W2_);

                //vector terkecil pemenang / J
                $D1_ = $lvq->hitungVector($x_, $W1_);
                $D2_ = $lvq->hitungVector($x_, $W2_);
                echo "<td>";
                echo $D1_;
                echo "<br></td>";
                echo "<td>";
                echo $D2_;
                echo "<br></td>";

                //vector kelas menang
                $J_ = $lvq->hitungVMin($D1_, $D2_);

                echo "<td>[";
                echo $J_;
                echo "]<br></td>"; //J nya


                //hitng kecocokan kelas output
                $sama_ = $lvq->cekOutput($J_, $x_[0]); //T=X_[0] ny
                //$sama="ya"; //hacktes

                echo "<td> <strong>";
                echo $sama_; //ya atau tidak per"sama"an kelas output nya
                echo "</strong></td>";

                //count ya/tidak
                if ($sama_ == "ya") {
                    $Yp = $Yp + 1;
                }
                if ($sama_ == "tidak") {
                    $Tp = $Tp + 1;
                }

                //count ya/tidak kelas sama
                if ($sama_ == "ya") {
                    if ($x_[0] == 1) {
                        $Yp1 = $Yp1 + 1;
                    } else {
                        //if($x_[0]==2){
                        $Yp2 = $Yp2 + 1;
                    }

                } else {
                    if ($sama_ == "tidak") {
                        if ($x_[0] == 1) {
                            $Tp2 = $Tp2 + 1;
                        } else {
                            //if($x_[0]==2){
                            $Tp1 = $Tp1 + 1;
                        }
                    }
                }


                /*echo "<td>W1= ";
                $lvq->showVector($W1_);
                echo "</td><td>W2= ";
                $lvq->showVector($W2_);
                echo "</td>";*/
                //AKHIR SATU DATA_____________________


            }
            echo "</tr></tr>
	    </tbody>
                    </table>
                    </div>";

            $centYp = 100 * $Yp / ($Yp + $Tp);
            $centTp = 100 * $Tp / ($Yp + $Tp);
            echo "Ya, Sama= " . $centYp . "% |" . $Yp;
            echo "<br>";

            echo "Tidak sama= " . $centTp . "% |" . $Tp;
            echo "<br>";

            $centYp1 = 100 * $Yp1 / ($Yp + $Tp);
            $centTp1 = 100 * $Tp1 / ($Yp + $Tp);
            $centYp2 = 100 * $Yp2 / ($Yp + $Tp);
            $centTp2 = 100 * $Tp2 / ($Yp + $Tp);

//sum works
            $SUMYp1 += $Yp1;
            $SUMTp1 += $Tp1;
            $SUMYp2 += $Yp2;
            $SUMTp2 += $Tp2;
            $SUMYp += $Yp;
            $SUMTp += $Tp;


            echo " <table id='viewTabel' class='table table-bordered table-striped table-hover'>
                        <thead style='background-color:#76B9FC'>";
            echo "<tr>";
            echo "<th></th>";
            echo "<th>Actual 1</th>";
            echo "<th>Actual 2</th>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><b>Predicted 1</b></td>";

            echo "<td>" . $centYp1 . "% |" . $Yp1 . "</td>";
            echo "<td>" . $centTp1 . "% |" . $Tp1 . "</td>";

            echo "</tr>";
            echo "<tr>";
            echo "<td><b>Predicted 2</b></td>";
            echo "<td>" . $centTp2 . "% |" . $Tp2 . "</td>";
            echo "<td>" . $centYp2 . "% |" . $Yp2 . "</td>";

            echo "</tr>";

            echo "</table> <br>";


            if ($centYp >= $AkurasiAkhir) {
                $AkurasiAkhir = $centYp;
                $PengujianTerbaik = $perulanganKfold;
                $W1Akhir = $W1;
                $W2Akhir = $W2;
                echo " <br> Akurasi Lebih Besar Dari Sebelumnya <br>";
            } else {
                echo " <br> Akurasi Lebih Kecil Dari Sebelumnya <br>";
            }

        }

        echo "end";
        echo "</br>";
        echo "</br>";
//__
        echo "<h3>HASIL AKHIR, AKURASI TERBAIK ADALAH " . $AkurasiAkhir . "% PADA PENGUJIAN KE " . $PengujianTerbaik . " </h3>";
        $W1__ = $lvq->showVector__Kelas($W1Akhir);
        echo "</br>";
        echo "</br>";
        $W2__ = $lvq->showVector__Kelas($W2Akhir);
        //exit();


    }


    public function wew()
    {

        $alfa = 0.025;
        $window = 0.2;
        $kfold = 10;
        return view('detailhasil', compact('alfa', 'window', 'kfold'));
    }

    public function store(Request $request)
    {
        //penggunakan class
        $Normalisasi = new DataController();
        $lvq = new Lvq();

        //variabel
        $alfa = $request->alfa;
        $window = $request->window;
        $kfold = $request->kfold;
        $file = public_path() . '/upload/' . $request->namafile . '.txt';

        $totalAkurasi = 0;
        $akurasiAkhir = 0;
        $akurasiRataRata = 0;
        $W1Akhir = 0;
        $W2Akhir = 0;
        $epochAkhir = 0;
        $kfoldTerbaik = 0;

        $jumlahciri = $Normalisasi->GetJumlahCiri($file);
        $dataNormalisasi = $Normalisasi->GetDataNormalisasi($file);
        //print_r($data);

        $totalData = count($dataNormalisasi['data_0']);
        $bagi = ($totalData / $kfold);
        //perulangan k fold
        $perulanganKfold = 0;

        for ($tr0 = 0; $tr0 < $totalData; $tr0 = $tr0 + $bagi) {
            $batasawal = $tr0;
            $batasakhir = $tr0 + ($bagi - 1);
            /*echo "ambil data dimulai dari " . $batasawal . "-" . $batasakhir;
            echo "<br>";
            echo "kfold ke ".$perulanganKfold++;
            echo "<br>";*/

        $latih = $lvq->PelatihanLVQ($alfa, $window, $kfold, $dataNormalisasi, $jumlahciri, $batasawal, $batasakhir);

        $W1 = $latih['w1'];
        $W2 = $latih['w2'];

        $uji = $lvq->PengujianLVQ($W1, $W2,$dataNormalisasi, $jumlahciri, $batasawal, $batasakhir);

        //dd($latih);
        //$dataPelatihan = $uji['output'];
        //\helpers::tabelPengujian($dataPelatihan);

        $totalAkurasi = $totalAkurasi + $uji['akurasi']['sama'];
        if($akurasiAkhir <= $uji['akurasi']['sama'])
        {
            $akurasiAkhir = $uji['akurasi']['sama'];
            $W1Akhir = $W1;
            $W2Akhir = $W2;
            $epochAkhir = $latih['epoch'];
            $kfoldTerbaik = $perulanganKfold;

        }
        }
        $akurasiRataRata = $totalAkurasi / $kfold;
        $W1V = $lvq->showVector__Kelas($W1Akhir);
        $W2V = $lvq->showVector__Kelas($W2Akhir);

        echo "total = ".$akurasiRataRata;

        //simpan data
        $DataHasil = new Hasils();
        $DataHasil->jnsQolqolah = $request->namafile;
        $DataHasil->totalData = $totalData;
        $DataHasil->totalDataLatih = $totalData - count($uji['output']);
        $DataHasil->totalDataUji = count($uji['output']);
        $DataHasil->alfa = $request->alfa;
        $DataHasil->window = $request->window;
        $DataHasil->kfold = $request->kfold;
        $DataHasil->epoch = $epochAkhir;
        $DataHasil->pengujianTerbaik = $kfoldTerbaik;
        $DataHasil->akurasiTerbaik = $akurasiAkhir;
        $DataHasil->akurasiRataRata = $akurasiRataRata;
        $DataHasil->vektor1 = $W1V;
        $DataHasil->vektor2 = $W2V;
        $DataHasil->save();



    }

}