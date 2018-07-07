<?php
/**
 * Copyright (c) 2018. Bobby Syahronanda
 * Name : Bobby Syahronanda., MTA
 * Email  : Bobbysyahronanda@gmail.com
 * Today : 3/17/18 12:06 PM
 */

/**
 * Created by PhpStorm.
 * User: syahronanda
 * Date: 17/03/18
 * Time: 12:06
 */
use App\Formula\Lvq;

class helpers
{
    public static function addTable($info, $jumlah)
    {

        echo "<thead class='text-primary'>
          <th>NO</th>";
        for ($i = 1; $i < $jumlah; $i++) {
            echo "<th>CR" . $i . "</th>";
        }
        echo "<th>Status Suara</th>
          </thead>
          <tbody>";

        for ($arr = 0; $arr < count($info['data_1']); $arr++) {
            $no = $arr + 1;
            if ($info['data_' . ($jumlah - 1)][$arr] == 1) {
                echo "<tr >";
            }else{
                echo "<tr >";
            }
                echo "<td>$no</td>";
                for ($label = 0; $label < ($jumlah - 1); $label++) {
                    echo "<td>" . $info['data_' . $label][$arr] . "</td>";
                }
                if ($info['data_' . ($jumlah - 1)][$arr] == 1) {
                    echo "<td data-background-color='green'> Benar </td></tr>";
                } else {
                    echo "<td data-background-color='red'> Salah </td></tr>";
                }
            }
            echo "</tbody>";
        }

        public
        static function tabelPengujian($data)
        {

            echo "<table class='table table-bordered table-striped table-hover' border='1'>
                    <thead style='background-color:#6bfc19'>
                            <tr>
								 <th>Data ke</th>
                                <th>Kelas Input</th>
                                <th>Hitng Vektor D1</th>
                                <th>Hitng Vektor D2</th>
                                <th>Kelas Prediksi</th>
                                <th>Kelas Output<br>(sama)</th>
                                                                                        
                            </tr>
                        </thead>
                        <tbody>";
            $no = 0;
            $lvq = new Lvq();
            foreach ($data as $Data) {

                //dd($Data);
                echo "<tr>
                  <td>" . ($no + 1) . "</td>";
                echo "<td>";
                $lvq->showVector($Data['kelas_input']);
                echo "</td>";
                echo "<td>" . $Data['vektorD1'] . "</td>";
                echo "<td>" . $Data['vektorD2'] . "</td>";
                echo "<td>" . $Data['prediksi'] . "</td>";
                echo "<td>" . $Data['status'] . "</td>";

                echo "</tr>";
                $no++;
            }
            echo "</tbody></table>";
        }
    }