<?php

class ShippingHelper
{
    public static function distanceFromSurabaya($city)
    {
        $city = strtolower(trim($city));

        return match ($city) {
            // Jawa Timur
            'surabaya' => 5000,
            'sidoarjo' => 6000,
            'malang' => 8000,
            'pasuruan' => 7000,
            'probolinggo' => 7500,
            'kediri' => 9000,
            'jember' => 10000,
            'banyuwangi' => 12000,

            // Jawa Tengah
            'solo' => 12000,
            'yogyakarta' => 13000,
            'semarang' => 15000,
            'purwokerto' => 16000,
            'tegal' => 17000,

            // Jawa Barat
            'jakarta' => 20000,
            'bogor' => 21000,
            'depok' => 20500,
            'tangerang' => 21500,
            'bekasi' => 21000,
            'bandung' => 19000,
            'cirebon' => 17000,
            'tasikmalaya' => 18000,

            // Sumatera
            'medan' => 50000,
            'palembang' => 35000,
            'bandar lampung' => 30000,

            // Kalimantan
            'pontianak' => 35000,
            'banjarmasin' => 30000,
            'balikpapan' => 28000,

            // Bali & NTB
            'denpasar' => 15000,
            'mataram' => 18000,

            // Sulawesi
            'makassar' => 30000,

            // Default (kota lain / belum ada)
            default => 12000,
        };
    }

    public static function calculateOngkir($distance): int
    {
        return (int) $distance * 10;
    }

    // 🔥 INI YANG DIPAKAI CONTROLLER
    public static function getOngkirByCity(string $city): int
    {
        $distance = self::distanceFromSurabaya($city);
        return self::calculateOngkir($distance);
    }
}
