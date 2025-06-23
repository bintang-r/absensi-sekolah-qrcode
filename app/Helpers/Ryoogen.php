<?php
/**
 *  Ryoogen Helper
 *  This file contains helper functions for the Ryoogen application.
 *  It includes functions for generating URLs, handling errors, and formatting data.
 *  *  @package Ryoogen
 *  *  @version 1.0
 *  *  @author Muhammad Bintang Powered By Ryoogen Media
 */

use Illuminate\Support\Facades\Cache;

/**
 * Mengecek apakah user sedang online
 * @param int $angka bilangan yang akan diubah menjadi teks
 * @return string teks yang merepresentasikan bilangan dalam bahasa Indonesia
 */
if (!function_exists('terbilang')) {
    function terbilang($angka)
    {
        $angka = abs($angka);
        $bilangan = [
            '',
            'Satu',
            'Dua',
            'Tiga',
            'Empat',
            'Lima',
            'Enam',
            'Tujuh',
            'Delapan',
            'Sembilan',
            'Sepuluh',
            'Sebelas'
        ];

        if ($angka < 12) {
            return $bilangan[$angka];
        } elseif ($angka < 20) {
            return terbilang($angka - 10) . ' Belas';
        } elseif ($angka < 100) {
            return terbilang($angka / 10) . ' Puluh ' . terbilang($angka % 10);
        } elseif ($angka < 200) {
            return 'Seratus ' . terbilang($angka - 100);
        } elseif ($angka < 1000) {
            return terbilang($angka / 100) . ' Ratus ' . terbilang($angka % 100);
        } elseif ($angka < 2000) {
            return 'Seribu ' . terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            return terbilang($angka / 1000) . ' Ribu ' . terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            return terbilang($angka / 1000000) . ' Juta ' . terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            return terbilang($angka / 1000000000) . ' Miliar ' . terbilang($angka % 1000000000);
        } else {
            return terbilang($angka / 1000000000000) . ' Triliun ' . terbilang($angka % 1000000000000);
        }
    }
}

/**
 * Mengecek apakah user sedang online
 *
 * @param string $id id dari user
 * @return boolean
 */
if (!function_exists('is_online')) {
    function is_online($id)
    {
        return Cache::has('user-is-online-' . $id) ? true : false;
    }
}

/**
 * Filter user showing
 *
 * @param object $query query builder
 * @return object $data hasil query
 */
if (!function_exists('secret_user')) {
    function secret_user($query)
    {
        if(in_array(auth()->user()->email, config('const.secret_email'))){
            $query = $query->whereNotIn('email', config('const.secret_email'));
        }

        return $query;
    }
}
