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
        echo "<br>";
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
}