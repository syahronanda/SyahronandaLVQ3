<?php
/**
 * Copyright (c) 2018. Bobby Syahronanda
 * Name : Bobby Syahronanda., MTA
 * Email  : Bobbysyahronanda@gmail.com
 * Today : 3/19/18 3:26 PM
 */

/**
 * Created by PhpStorm.
 * User: syahronanda
 * Date: 19/03/18
 * Time: 15:26
 */
namespace App\Formula;

use App\Http\Controllers\DataController;

class Lvq
{
    function decimal6($number)
    {
        return 1 * (number_format((float)$number, 6, '.', ''));
    }

    //melihat deret vector
    function showVector($vector)
    {
        for ($i = 1; $i < count($vector); $i++) {
            //arraylenth??
            echo $vector[$i];
            echo ", ";
        }
        echo "Kelas= " . $vector[0];
        //echo "<br>";
    }

    //melihat deret vector tanpa kelas
    function showVector__Kelas($vector)
    {
        $returns = '';
        for ($i = 1; $i < count($vector); $i++) {
            //arraylenth??
            echo $vector[$i];
            $returns = $returns . $vector[$i];
            if ($i == (count($vector) - 1)) {
            } else {
                echo ", ";
                $returns = $returns . ", ";
            };
        }
        return $returns;

    }

    //melihat kelas asli vector
    function showVectorKelas($vector)
    {
        echo $vector[0];
    }

    //ALGO FUNCTION LATIH
    //1. hitung vector mencari D1/D2
    function hitungVector($x, $W)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
        $T = $x[0];//kelas
        $D = 0;
        for ($i = 1; $i < count($x); $i++) { //mencari SUM selisih vector
            $Dtemp = pow(($x[$i] - $W[$i]), 2);
            $D = $Dtemp + $D;
        }
        $D = sqrt($D);
        return (self::decimal6($D));

    }

    //menghitung vector terkecil
    function hitungVMin($D1, $D2)
    { //khusus lvq
        if ($D1 > $D2) {
            return 2;
        } else {
            return 1;
        }
    }

    //menghitung vector terkecil dan runnerup
    function hitungVMin_2($D1, $D2)
    { //khusus lvq3
        if ($D1 > $D2) {
            return array(2, 1);
        } else {
            return array(1, 2);
        }
    }

    //2. Cek kebenaran Output
    function cekOutput($J, $T)
    {
        if ($J == $T) {
            return "ya";
        } else {
            return "tidak";
        }

    }

    //3. Update Vektor
    function updateKurang1($x, $W, $a)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
        $T = $x[0];//kelas
        $D = 0;
        for ($i = 1; $i < count($x); $i++) { //Update Vector
            // $W[$i]=$W[$i]-($a*($x[$i]-$W[$i])); //krng
            $W[$i] = self::decimal6($W[$i] - ($a * ($x[$i] - $W[$i]))); //krng
        }
        return $W;
    }

    function updateTambah1($x_, $W_, $a_)
    {
        ini_set('memory_limit', '-1');
        ini_set('ma_x__ex_ecution_time', 0);
        $T_ = $x_[0];//kela_s
        $D_ = 0;
        for ($i = 1; $i < count($x_); $i++) { //upda_te vector
            // $W_[$i]=$W_[$i]+($a_*($x_[$i]-$W_[$i])); //tmba_h
            $W_[$i] = self::decimal6($W_[$i] + ($a_ * ($x_[$i] - $W_[$i]))); //tmba_h

            //$D_=$Dtemp+$D_;
        }

        return $W_;
    }

    //proses pelatihan
    function PelatihanLVQ($alfa, $window, $kfold, $dataNormalisasi, $jumlahciri, $batasawal, $batasakhir)
    {
        //inisialisisi formula
        $lvq = new Lvq();
        $prosesData = new DataController();
        $Window = new Window();

        //set variabel
        $setWW1 = false;
        $setWW2 = false;
        $epoch = 0;
        $data = $prosesData->GetData($dataNormalisasi, $jumlahciri, $batasawal, $batasakhir, 'Latih');
        $totalData = count($dataNormalisasi['data_0']);
//
        for ($i = 0; $i < (count($dataNormalisasi['data_0'])); $i++) {

            if (($i >= $batasawal) && ($i <= $batasakhir)) {
                continue;
            } else {

                if ($setWW1 == false) {
                    if ($data[0][$i] == 1) {
                        //echo "ketemu data W1 " . $i;
                        $setWW1 = true;
                        $ww1 = $i;
                    }
                }

                if ($setWW2 == false) {
                    if ($data[0][$i] == 2) {
                        //echo "ketemu data W2 " . $i;
                        $setWW2 = true;
                        $ww2 = $i;
                    }
                }

                if ($setWW1 == true && $setWW2 == true) {
                    break;
                }
            }

        }
        /*echo 'data adalah ' . $ww1 . ' dan ' . $ww2 . "<br>";*/

        for ($i = 0; $i < $jumlahciri; $i++) {
            $W1[$i] = $data[$i][$ww1];
            $W2[$i] = $data[$i][$ww2];
        }

        /*echo "W1 Awal :";
        $lvq->showVector($W1);
        echo "W2 Awal :";
        $lvq->showVector($W2);*/


        $bagi = $totalData / $kfold;

        //Mulai Loop EPOCH

        while (($epoch < 50)) {
            //min alfa
            if ($alfa < 0.02) {// ini min alfa
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
                                $W1 = $lvq->updateTambah1($x, $W1, $alfa);  //(+)
                            } else {
                                $W2 = $lvq->updateTambah1($x, $W2, $alfa);  //(+)
                            }
                        } else {                    //T=C1_tidak
                            //defined jarak terkecil:sudah, diatas
                            if ($Window->cekWindow3($Da, $Db, $window) == "true") {    //deteksi window
                                $masukIf = "masuk window<br>";
                                // if(){} bypass??

                                if ($J == 1) {
                                    $W1 = $lvq->updateKurang1($x, $W1, $alfa); //(-)
                                    $W2 = $lvq->updateTambah1($x, $W2, $alfa); //(+)
                                } else {
                                    $W2 = $lvq->updateKurang1($x, $W2, $alfa); //(-)
                                    $W1 = $lvq->updateTambah1($x, $W1, $alfa); //(+)
                                }


                            } else {
                               // $masukIf = "dijauhi vektor<br>";
                                if ($J == 1) {
                                    $W1 = $lvq->updateKurang1($x, $W1, $alfa); //(-)
                                } else {
                                    $W2 = $lvq->updateKurang1($x, $W2, $alfa); //(-)
                                }
                            }
                        }
                        //AKHIR SATU DATA_____________________

                    }
                }
            }
            $epoch++;
            $alfa = $alfa - (0.1 * $alfa); //pengurangan alfa/learning rate

        }

        $Data['epoch'] = $epoch;
        $Data['w1'] = $W1;
        $Data['w2'] = $W2;

        return $Data;

    }

    //proses pengujian
    function PengujianLVQ($W1,$W2,$dataNormalisasi,$jumlahciri,$batasawal,$batasakhir)
    {
//bagian pengujian

        //variabel
        $lvq = new Lvq();
        $prosesData = new DataController();
        $datauji = $prosesData->GetData($dataNormalisasi, $jumlahciri, $batasawal, $batasakhir, 'Uji');
        $W1_ = $W1;
        $W2_ = $W2;
        $Yp = $Tp = 0;
        $Yp1 = $Tp1 = $Yp2 = $Tp2 = 0;
        $index = 0;
        for ($b_ = $batasawal; $b_ < (count($datauji[0]) + $batasawal); $b_++) {


            $k_ = $b_;

            //define X Output
            for ($i_ = 0; $i_ < count($datauji); $i_++) {
                $x_[$i_] = $datauji[$i_][$k_];


            } // $x_= array(1,0.335,0,1,0,0,0.5,1,0,0.468); //T ny 1?


            //print_r ($W1_); echo "<br>";
            $output[$index]['kelas_input'] = $x_;

            //vector terkecil pemenang / J
            $D1_ = $lvq->hitungVector($x_, $W1_);
            $D2_ = $lvq->hitungVector($x_, $W2_);
            $output[$index]['vektorD1'] = $D1_;
            $output[$index]['vektorD2'] = $D2_;

            //vector kelas menang
            $J_ = $lvq->hitungVMin($D1_, $D2_);
            $output[$index]['prediksi'] = $J_;



            //hitng kecocokan kelas output
            $sama_ = $lvq->cekOutput($J_, $x_[0]); //T=X_[0] ny
            $output[$index]['status'] = $sama_;

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
            //AKHIR SATU DATA_____________________
            $index++;
        }

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


        /*if ($centYp >= $AkurasiAkhir) {
            $AkurasiAkhir = $centYp;
            $PengujianTerbaik = $perulanganKfold;
            $W1Akhir = $W1;
            $W2Akhir = $W2;
            $EpochAkhir = $epoch;
            echo " <br> Akurasi Lebih Besar Dari Sebelumnya <br>";
        } else {
            echo " <br> Akurasi Lebih Kecil Dari Sebelumnya <br>";
        }
        $TotalAkurasi = $TotalAkurasi + $centYp;*/

        $akurasi['sama'] = $centYp;
        $akurasi['datasama'] = $Yp;
        $akurasi['tidaksama'] = $centTp;
        $akurasi['datatidaksama'] = $Tp;

        $hasillatih ['output'] = $output;
        $hasillatih ['akurasi'] = $akurasi;
        return $hasillatih;
    }
}