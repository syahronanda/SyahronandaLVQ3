<?php
/**
 * Copyright (c) 2018. Bobby Syahronanda
 * Name : Bobby Syahronanda., MTA
 * Email  : Bobbysyahronanda@gmail.com
 * Today : 3/19/18 3:12 PM
 */

/**
 * Created by PhpStorm.
 * User: syahronanda
 * Date: 19/03/18
 * Time: 15:12
 */
namespace App\Formula;

class Window
{

    function cekWindow2($D1, $D2, $e)
    {
        if ((($D1) > ((1 - $e) * $D2)) && (($D2) < ((1 + $e) * $D1))) {
            return "true";
        } else {
            return "false";
        }
    }


    function cekWindow2_1($D1, $D2, $e)
    {

        //cek minimal prbandingan D1/D2 atau D2/D1
        if (($D1 / $D2) > ($D2 / $D1)) {
            //D2/D1 yang terpilih sebagai $min
            $min_ = ($D2 / $D1);
            $max_ = ($D1 / $D2);
        } else {
            //else
            $min_ = ($D1 / $D2);
            $max_ = ($D2 / $D1);
        }
        $s_ = ((1 - $e) / (1 + $e));
        $z_ = ((1 - $e) / (1 + $e));
        //Cek window
        if (($min_ > (1 - $e)) && ($max_ < (1 + $e))) {
            return "true";
        } else {
            return "false";
        }
    }


    function cekWindow3_($D1, $D2, $e)
    {
       //cek minimal prbandingan D1/D2 atau D2/D1
        if (($D1 / $D2) > ($D2 / $D1)) {
            //D2/D1 yang terpilih sebagai $min
            $min = ($D2 / $D1);
        } else {
            //else
            $min = ($D1 / $D2);    //kali
        }
        $s = ((1 - $e) / (1 + $e)); //dibagi
        //Cek window
        if ($min > $s) {
            return "true";
        } else {
            return "false";
        }
    }


    function cekWindow3($D1, $D2, $e)
    {
        //cek minimal prbandingan D1/D2 atau D2/D1
        if (($D1 / $D2) > ($D2 / $D1)) {

            //D2/D1 yang terpilih sebagai $min
            $min = ($D2 / $D1);
        } else {
            //else
            $min = ($D1 / $D2);  //bagi
        }

        $s = ((1 - $e) * (1 + $e)); //dikali

        //Cek window
        if ($min > $s) {
            return "true";
        } else {
            return "false";
        }
    }
}