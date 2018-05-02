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
class helpers
{
    public static function addTable($info, $jumlah)
    {

        echo "<thead class='text-primary'>
          <th>NO</th>";
        for ($i = 1; $i < $jumlah; $i++) {
            echo "<th>CR" . $i . "</th>";
        }
        echo "<th>Status</th>
          </thead>
          <tbody>";

        for ($arr = 0; $arr < count($info['data_1']); $arr++) {
            $no = $arr + 1;
            echo "<tr>
                  <td>$no</td>";
            for ($label = 0; $label < ($jumlah - 1); $label++) {
                echo "<td>" . $info['data_' . $label][$arr] . "</td>";
            }

            echo "<td>" . $info['data_' . ($jumlah - 1)][$arr] . "</td></tr>";

        }
        echo "</tbody>";
    }
}