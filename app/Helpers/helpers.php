<?php
// app/Helpers/helpers.php

if (!function_exists('formatRupiahShort')) {
    function formatRupiahShort($number)
    {
        // Hanya format jika harga >= 1 Milyar
        if ($number >= 1000000000) {
            $value = $number / 1000000000;
            if (floor($value) == $value) {
                return 'Rp ' . number_format($value, 0, ',', '.') . ' M';
            }
            return 'Rp ' . number_format($value, 2, ',', '.') . ' M';
        }
        
        // Jika di bawah 1 Milyar, format ke Juta (JT)
        if ($number >= 1000000) {
            return 'Rp ' . number_format($number / 1000000, 0, ',', '.') . ' JT';
        }
        
        // Di bawah 1 Juta, tampilkan angka penuh
        return 'Rp ' . number_format($number, 0, ',', '.');
    }
}