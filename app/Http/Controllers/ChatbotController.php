<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $message = trim($request->message);
        
        if (empty($message)) {
            return response()->json([
                'reply' => 'Silakan tulis pertanyaan Anda. 😊'
            ]);
        }

        // Log untuk debugging
        \Log::info('Chatbot message: ' . $message);

        $lowerMessage = strtolower($message);

        // ======================================================
        // 1. SAPAAN / PERKENALAN
        // ======================================================
        if ($this->contains($lowerMessage, ['halo', 'hai', 'hi', 'selamat pagi', 'selamat siang', 'selamat malam', 'assalamualaikum', 'hello'])) {
            return response()->json([
                'reply' => $this->getGreetingResponse($message)
            ]);
        }

        // ======================================================
        // 2. UCAPAN TERIMA KASIH
        // ======================================================
        if ($this->contains($lowerMessage, ['terima kasih', 'makasih', 'thanks', 'thank you', 'trims'])) {
            return response()->json([
                'reply' => "Sama-sama! 😊\n\nSenang bisa membantu Anda menemukan properti impian.\n\n" .
                          "Jangan ragu untuk bertanya lagi jika ada yang perlu dibantu. 🏠✨"
            ]);
        }

        // ======================================================
        // 3. INFORMASI KPR / CICILAN
        // ======================================================
        if ($this->contains($lowerMessage, ['kpr', 'cicilan', 'dp', 'kredit', 'bunga', 'tenor', 'simulasi kpr'])) {
            return response()->json([
                'reply' => $this->getKPRInfo($message)
            ]);
        }

        // ======================================================
        // 4. REKOMENDASI PROPERTI BERDASARKAN BUDGET
        // ======================================================
        if ($this->contains($lowerMessage, ['cari', 'rekomendasi', 'budget', 'rumah', 'properti', 'saran', 'hunian'])) {
            $budget = $this->extractBudget($message);
            if ($budget) {
                return $this->getBudgetRecommendation($budget);
            }
        }

        // ======================================================
        // 5. TAMPILKAN SEMUA PROPERTI
        // ======================================================
        if ($this->contains($lowerMessage, ['semua properti', 'all properti', 'tampilkan semua', 'daftar properti', 'list properti'])) {
            return $this->getAllProperties();
        }

        // ======================================================
        // 6. REKOMENDASI PROPERTI TERMURAH / TERMAHAL
        // ======================================================
        if ($this->contains($lowerMessage, ['termurah', 'paling murah', 'harga terendah', 'termahal', 'paling mahal', 'harga tertinggi'])) {
            return $this->getPropertyByPrice($lowerMessage);
        }

        // ======================================================
        // 7. PENCARIAN PROPERTI BERDASARKAN LOKASI (DIPERBAIKI)
        // ======================================================
        $locationResult = $this->searchByLocation($message);
        if ($locationResult) {
            return $locationResult;
        }

        // ======================================================
        // 8. PENCARIAN PROPERTI BERDASARKAN TIPE
        // ======================================================
        $typeResult = $this->searchByType($message);
        if ($typeResult) {
            return $typeResult;
        }

        // ======================================================
        // 9. PERBANDINGAN PROPERTI
        // ======================================================
        if ($this->contains($lowerMessage, ['bandingkan', 'compare', 'perbedaan', 'mana yang lebih'])) {
            return $this->compareProperties($message);
        }

        // ======================================================
        // 10. INFORMASI TENTANG METODE SAW
        // ======================================================
        if ($this->contains($lowerMessage, ['saw', 'metode saw', 'simple additive weighting'])) {
            return response()->json([
                'reply' => "📊 *Metode SAW (Simple Additive Weighting)*\n\n" .
                          "SAW adalah metode yang digunakan untuk menilai dan memilih properti terbaik berdasarkan beberapa kriteria.\n\n" .
                          "*Kriteria yang dinilai:*\n" .
                          "• Harga Properti (semakin rendah semakin baik)\n" .
                          "• Luas Bangunan (semakin luas semakin baik)\n" .
                          "• Jumlah Kamar Tidur\n" .
                          "• Jumlah Kamar Mandi\n" .
                          "• Kondisi Bangunan\n" .
                          "• Grade Properti\n\n" .
                          "💡 Sistem kami menggunakan metode ini untuk memberikan rekomendasi properti terbaik sesuai kebutuhan Anda!"
            ]);
        }

        // ======================================================
        // 11. ABOUT / TENTANG KAMI
        // ======================================================
        if ($this->contains($lowerMessage, ['tentang', 'about', 'properti merah putih', 'website ini'])) {
            return response()->json([
                'reply' => "🏠 *Tentang Properti Merah Putih*\n\n" .
                          "Properti Merah Putih adalah sistem pendukung keputusan pemilihan properti yang membantu Anda menemukan hunian terbaik.\n\n" .
                          "*Fitur yang tersedia:*\n" .
                          "• Katalog Properti\n" .
                          "• Simulasi KPR\n" .
                          "• Analisis Finansial\n" .
                          "• Rekomendasi SAW\n" .
                          "• Perbandingan Properti\n" .
                          "• Dashboard\n\n" .
                          "💡 Temukan properti impian Anda bersama kami!"
            ]);
        }

        // ======================================================
        // 12. FITUR / BANTUAN
        // ======================================================
        if ($this->contains($lowerMessage, ['fitur', 'bantuan', 'help', 'tolong', 'menu', 'command'])) {
            return response()->json([
                'reply' => "📋 *Daftar Fitur & Perintah*\n\n" .
                          "• *Cari properti*: 'Cari rumah budget 500 juta'\n" .
                          "• *Rekomendasi*: 'Rekomendasi properti 400 juta'\n" .
                          "• *Info KPR*: 'Info KPR' atau 'Simulasi KPR'\n" .
                          "• *Semua properti*: 'Tampilkan semua properti'\n" .
                          "• *Termurah*: 'Properti termurah'\n" .
                          "• *Termahal*: 'Properti termahal'\n" .
                          "• *Cari lokasi*: 'Properti di Surabaya' atau 'Cari properti Jakarta'\n" .
                          "• *Cari tipe*: 'Rumah' atau 'Apartemen'\n" .
                          "• *Bandingkan*: 'Bandingkan properti 1 dan 2'\n" .
                          "• *Info SAW*: 'Apa itu metode SAW'\n" .
                          "• *Tentang*: 'Tentang Properti Merah Putih'\n\n" .
                          "Ada yang bisa saya bantu? 😊"
            ]);
        }

        // ======================================================
        // 13. DEFAULT RESPONSE (TIDAK DIKETAHUI)
        // ======================================================
        return response()->json([
            'reply' => "Maaf, saya belum bisa memahami pertanyaan Anda. 🙏\n\n" .
                      "Coba tanyakan salah satu dari ini:\n" .
                      "• 'Halo' untuk sapaan\n" .
                      "• 'Info KPR' untuk informasi KPR\n" .
                      "• 'Cari rumah budget 500 juta' untuk rekomendasi\n" .
                      "• 'Properti di Lamongan' untuk cari lokasi\n" .
                      "• 'Fitur' untuk melihat semua perintah\n\n" .
                      "Atau gunakan menu di atas untuk fitur lengkap! 😊"
        ]);
    }

    // ======================================================
    // FUNGSI PEMBANTU
    // ======================================================

    private function contains($message, $keywords)
    {
        foreach ($keywords as $keyword) {
            if (strpos($message, $keyword) !== false) {
                return true;
            }
        }
        return false;
    }

    private function extractBudget($message)
    {
        $patterns = [
            '/(\d+)\s*(juta|jt|juta-an)/i',
            '/(\d+)\s*m/i',
            '/(\d{1,3}(?:\.\d{3})*)/',
            '/(\d+)/'
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $message, $matches)) {
                $number = (int) str_replace('.', '', $matches[1]);
                
                if (strpos($message, 'juta') !== false || strpos($message, 'jt') !== false) {
                    return $number * 1000000;
                }
                
                if ($number > 100000) {
                    return $number;
                }
                
                if ($number > 0 && $number < 100000) {
                    return $number * 1000000;
                }
            }
        }
        return null;
    }

    private function getGreetingResponse($message)
    {
        $time = date('H');
        $greeting = 'Halo';
        
        if ($time < 12) {
            $greeting = 'Selamat pagi';
        } elseif ($time < 15) {
            $greeting = 'Selamat siang';
        } elseif ($time < 18) {
            $greeting = 'Selamat sore';
        } else {
            $greeting = 'Selamat malam';
        }
        
        return "{$greeting}! 👋\n\nSaya adalah AI Assistant Properti Merah Putih.\n\nSaya bisa membantu Anda:\n" .
               "• Mencari properti sesuai budget\n" .
               "• Menghitung simulasi KPR\n" .
               "• Memberikan rekomendasi properti\n" .
               "• Membandingkan properti\n\n" .
               "Ketik 'Fitur' untuk melihat semua perintah! 😊";
    }

    private function getKPRInfo($message)
    {
        $price = $this->extractBudget($message);
        
        if ($price) {
            $dp = $price * 0.2;
            $loan = $price - $dp;
            $tenor = 20;
            $bunga = 0.08;
            $monthly = ($loan * $bunga/12 * pow(1 + $bunga/12, $tenor*12)) / (pow(1 + $bunga/12, $tenor*12) - 1);
            
            return "🏠 *Simulasi KPR untuk Rp" . number_format($price, 0, ',', '.') . "*\n\n" .
                   "• Harga Properti: Rp" . number_format($price, 0, ',', '.') . "\n" .
                   "• DP 20%: Rp" . number_format($dp, 0, ',', '.') . "\n" .
                   "• Pinjaman: Rp" . number_format($loan, 0, ',', '.') . "\n" .
                   "• Tenor: {$tenor} tahun\n" .
                   "• Bunga: 8% per tahun\n" .
                   "• Cicilan/bulan: Rp" . number_format($monthly, 0, ',', '.') . "\n\n" .
                   "💡 Gunakan fitur 'Simulasi KPR' untuk perhitungan lebih detail!";
        }
        
        return "🏠 *Informasi KPR*\n\n" .
               "• DP minimal 15-20% dari harga properti\n" .
               "• Tenor maksimal 20-30 tahun\n" .
               "• Bunga KPR sekitar 5-10% per tahun\n\n" .
               "📝 *Contoh Simulasi:*\n" .
               "Rumah Rp500 juta, DP 20% (Rp100 juta)\n" .
               "Cicilan 20 tahun ≈ Rp3-4 juta/bulan\n\n" .
               "💡 Kirimkan angka budget untuk simulasi! Contoh:\n" .
               "'Simulasi KPR 400 juta'";
    }

    private function getBudgetRecommendation($budget)
    {
        $properties = Property::where('price', '<=', $budget)
            ->orderBy('price', 'desc')
            ->limit(3)
            ->get();
        
        if ($properties->isEmpty()) {
            return response()->json([
                'reply' => "Maaf, untuk budget Rp" . number_format($budget, 0, ',', '.') . 
                           " belum ada properti yang tersedia.\n\n" .
                           "💡 *Saran:*\n" .
                           "• Tingkatkan budget Anda\n" .
                           "• Cek properti lain di website kami\n" .
                           "• Ketik 'semua properti' untuk melihat daftar lengkap"
            ]);
        }
        
        $reply = "🏠 *Rekomendasi Properti Budget Rp" . number_format($budget, 0, ',', '.') . "*\n\n";
        
        foreach ($properties as $property) {
            $reply .= "✅ *{$property->title}*\n";
            $reply .= "📍 {$property->location}\n";
            $reply .= "💰 Rp" . number_format($property->price, 0, ',', '.') . "\n";
            $reply .= "🛏 {$property->bedroom} KT | 🚿 {$property->bathroom} KM | 📐 {$property->building_area} m²\n\n";
        }
        
        $reply .= "💡 *Tips:*\n" .
                  "• Klik 'Lihat Detail' untuk info lengkap\n" .
                  "• Gunakan fitur 'Compare' untuk bandingkan\n" .
                  "• Simulasi KPR untuk hitung cicilan\n\n" .
                  "Ada yang bisa saya bantu lagi? 😊";
        
        return response()->json(['reply' => $reply]);
    }

    private function getAllProperties()
    {
        $properties = Property::orderBy('price')->limit(10)->get();
        
        if ($properties->isEmpty()) {
            return response()->json([
                'reply' => "Maaf, belum ada properti yang tersedia saat ini."
            ]);
        }
        
        $reply = "🏠 *Daftar Semua Properti*\n\n";
        
        foreach ($properties as $property) {
            $reply .= "✅ *{$property->title}*\n";
            $reply .= "📍 {$property->location}\n";
            $reply .= "💰 Rp" . number_format($property->price, 0, ',', '.') . "\n";
            $reply .= "🛏 {$property->bedroom} KT | 🚿 {$property->bathroom} KM | 📐 {$property->building_area} m²\n\n";
        }
        
        $reply .= "💡 *Tips:*\n" .
                  "• Klik 'Lihat Detail' untuk info lengkap setiap properti\n" .
                  "• Gunakan fitur 'Compare' untuk bandingkan\n\n" .
                  "Ada properti yang menarik minat Anda? 😊";
        
        return response()->json(['reply' => $reply]);
    }

    private function getPropertyByPrice($message)
    {
        if (strpos($message, 'termurah') !== false || strpos($message, 'paling murah') !== false || strpos($message, 'terendah') !== false) {
            $property = Property::orderBy('price', 'asc')->first();
            $label = "termurah";
        } else {
            $property = Property::orderBy('price', 'desc')->first();
            $label = "termahal";
        }
        
        if (!$property) {
            return response()->json([
                'reply' => "Maaf, belum ada data properti."
            ]);
        }
        
        $reply = "🏠 *Properti {$label}*\n\n" .
                 "✅ *{$property->title}*\n" .
                 "📍 {$property->location}\n" .
                 "💰 Rp" . number_format($property->price, 0, ',', '.') . "\n" .
                 "🛏 {$property->bedroom} KT | 🚿 {$property->bathroom} KM | 📐 {$property->building_area} m²\n\n" .
                 "💡 Klik 'Lihat Detail' untuk info lengkap!";
        
        return response()->json(['reply' => $reply]);
    }

    /**
     * PENCARIAN PROPERTI BERDASARKAN LOKASI (DIPERBAIKI - AMBIL DARI DATABASE)
     */
    private function searchByLocation($message)
    {
        // Ambil semua lokasi unik dari database
        $allLocations = Property::select('location')
            ->distinct()
            ->pluck('location')
            ->toArray();
        
        // Normalisasi lokasi (lowercase, hapus spasi berlebih)
        $normalizedLocations = [];
        foreach ($allLocations as $loc) {
            $normalizedLocations[strtolower(trim($loc))] = $loc;
        }
        
        // Cek apakah pesan mengandung nama lokasi
        foreach ($normalizedLocations as $lowerLoc => $originalLoc) {
            if (strpos(strtolower($message), $lowerLoc) !== false) {
                // Cari properti dengan lokasi tersebut
                $properties = Property::where('location', 'like', '%' . $originalLoc . '%')
                    ->orderBy('price')
                    ->get();
                
                if ($properties->isEmpty()) {
                    return response()->json([
                        'reply' => "Maaf, belum ada properti di *{$originalLoc}*."
                    ]);
                }
                
                $reply = "🏠 *Properti di {$originalLoc}*\n\n";
                foreach ($properties as $property) {
                    $reply .= "✅ *{$property->title}*\n";
                    $reply .= "📍 {$property->location}\n";
                    $reply .= "💰 Rp" . number_format($property->price, 0, ',', '.') . "\n";
                    $reply .= "🛏 {$property->bedroom} KT | 🚿 {$property->bathroom} KM | 📐 {$property->building_area} m²\n\n";
                }
                $reply .= "💡 Klik 'Lihat Detail' untuk info lengkap!";
                
                return response()->json(['reply' => $reply]);
            }
        }
        
        // Jika ada kata "di" atau "lokasi" tapi tidak ditemukan
        if (strpos($message, 'di') !== false || strpos($message, 'lokasi') !== false) {
            // Ambil daftar kota yang tersedia
            $availableCities = array_values($normalizedLocations);
            $cityList = "• " . implode("\n• ", array_slice($availableCities, 0, 10));
            
            if (count($availableCities) > 10) {
                $cityList .= "\n• dan " . (count($availableCities) - 10) . " kota lainnya";
            }
            
            return response()->json([
                'reply' => "📍 *Cari Properti Berdasarkan Lokasi*\n\n" .
                          "Silakan sebutkan nama kota yang ingin dicari.\n\n" .
                          "*Kota yang tersedia:*\n" .
                          $cityList . "\n\n" .
                          "Contoh: 'Properti di Surabaya' atau 'Cari rumah Lamongan'"
            ]);
        }
        
        return null;
    }

    private function searchByType($message)
    {
        $types = ['rumah', 'apartemen', 'townhouse', 'cluster', 'villa', 'tanah'];
        
        foreach ($types as $type) {
            if (strpos(strtolower($message), $type) !== false) {
                $properties = Property::where('property_type', 'like', '%' . $type . '%')
                    ->orderBy('price')
                    ->limit(3)
                    ->get();
                
                if ($properties->isEmpty()) {
                    return response()->json([
                        'reply' => "Maaf, belum ada properti tipe *" . ucfirst($type) . "*."
                    ]);
                }
                
                $reply = "🏠 *Properti Tipe " . ucfirst($type) . "*\n\n";
                foreach ($properties as $property) {
                    $reply .= "✅ *{$property->title}*\n";
                    $reply .= "📍 {$property->location}\n";
                    $reply .= "💰 Rp" . number_format($property->price, 0, ',', '.') . "\n";
                    $reply .= "🛏 {$property->bedroom} KT | 🚿 {$property->bathroom} KM\n\n";
                }
                return response()->json(['reply' => $reply]);
            }
        }
        
        return null;
    }

    private function compareProperties($message)
    {
        preg_match_all('/(\d+)/', $message, $matches);
        if (isset($matches[1]) && count($matches[1]) >= 2) {
            $idA = (int)$matches[1][0];
            $idB = (int)$matches[1][1];
            
            $propertyA = Property::find($idA);
            $propertyB = Property::find($idB);
            
            if ($propertyA && $propertyB) {
                $reply = "📊 *Perbandingan Properti*\n\n" .
                         "*{$propertyA->title}* vs *{$propertyB->title}*\n\n" .
                         "• *Harga*: Rp" . number_format($propertyA->price, 0, ',', '.') . " vs Rp" . number_format($propertyB->price, 0, ',', '.') . "\n" .
                         "• *Lokasi*: {$propertyA->location} vs {$propertyB->location}\n" .
                         "• *KT*: {$propertyA->bedroom} vs {$propertyB->bedroom}\n" .
                         "• *KM*: {$propertyA->bathroom} vs {$propertyB->bathroom}\n" .
                         "• *Luas*: {$propertyA->building_area} m² vs {$propertyB->building_area} m²\n\n" .
                         "💡 Gunakan fitur 'Compare' di menu untuk perbandingan lebih detail!";
                
                return response()->json(['reply' => $reply]);
            }
        }
        
        return response()->json([
            'reply' => "Untuk membandingkan properti, kirimkan ID properti.\n\n" .
                      "Contoh: 'Bandingkan 1 dan 2'\n\n" .
                      "Atau gunakan fitur 'Compare' di menu!"
        ]);
    }
}