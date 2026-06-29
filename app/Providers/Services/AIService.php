<?php

namespace App\Services;

use App\Models\Property;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';
    }

    public function generateResponse($userMessage)
    {
        // Jika tidak ada API Key, gunakan fallback
        if (empty($this->apiKey)) {
            return $this->getFallbackResponse($userMessage);
        }

        $properties = $this->getPropertyContext();
        $systemPrompt = $this->buildSystemPrompt($properties);

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $systemPrompt . "\n\nPertanyaan user: " . $userMessage]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 500,
                'topP' => 0.95,
                'topK' => 40
            ]
        ];

        try {
            $response = Http::timeout(30)->withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '?key=' . $this->apiKey, $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    return $data['candidates'][0]['content']['parts'][0]['text'];
                }
                
                return 'Maaf, saya tidak bisa memproses permintaan Anda saat ini.';
            } else {
                Log::error('Gemini API Error: ' . $response->body());
                return $this->getFallbackResponse($userMessage);
            }
        } catch (\Exception $e) {
            Log::error('Gemini API Exception: ' . $e->getMessage());
            return $this->getFallbackResponse($userMessage);
        }
    }

    private function buildSystemPrompt($properties)
    {
        $prompt = "Anda adalah AI Assistant untuk website Properti Merah Putih. 
Website ini adalah sistem rekomendasi properti dengan metode SAW (Simple Additive Weighting).

DATA PROPERTI YANG TERSEDIA:
";

        foreach ($properties as $property) {
            $prompt .= "
- Nama: {$property->title}
  Lokasi: {$property->location}
  Harga: Rp" . number_format($property->price, 0, ',', '.') . "
  Kamar Tidur: {$property->bedroom} KT
  Kamar Mandi: {$property->bathroom} KM
  Luas Bangunan: {$property->building_area} m²
  Tipe: {$property->property_type}
";
        }

        $prompt .= "

PANDUAN RESPON:
1. Berikan rekomendasi properti berdasarkan budget yang disebutkan user
2. Jika user bertanya tentang simulasi KPR, berikan informasi DP dan cicilan
3. Gunakan bahasa Indonesia yang sopan dan ramah
4. Gunakan emoji yang relevan 🏠💰📍📊
5. Jika user bertanya di luar konteks properti, arahkan ke fitur website

Sekarang, balas pertanyaan user dengan ramah dan informatif.";

        return $prompt;
    }

    private function getPropertyContext()
    {
        return Property::select('id', 'title', 'location', 'price', 'bedroom', 'bathroom', 'building_area', 'property_type')
            ->orderBy('price')
            ->limit(20)
            ->get();
    }

    public function getFallbackResponse($message)
    {
        $lowerMessage = strtolower($message);
        
        // Deteksi budget
        preg_match('/(\d+)\s*(juta|jt|m)?/i', $lowerMessage, $matches);
        $budget = isset($matches[1]) ? (int)$matches[1] : null;
        
        if (isset($matches[2]) && in_array($matches[2], ['juta', 'jt', 'm'])) {
            $budget = $budget * 1000000;
        } elseif ($budget && $budget < 100000) {
            $budget = $budget * 1000000;
        }
        
        if ($budget && strpos($lowerMessage, 'cari') !== false) {
            return $this->getBudgetRecommendation($budget);
        }
        
        if (strpos($lowerMessage, 'kpr') !== false || strpos($lowerMessage, 'cicilan') !== false) {
            return "🏠 *Informasi KPR*\n\n" .
                   "• DP minimal 15-20% dari harga properti\n" .
                   "• Tenor maksimal 20-30 tahun\n" .
                   "• Bunga KPR sekitar 5-10% per tahun\n\n" .
                   "💡 Gunakan fitur 'Simulasi KPR' di menu kami untuk perhitungan detail!\n\n" .
                   "Contoh: Rumah Rp500 juta, DP 20% (Rp100 juta), cicilan 20 tahun sekitar Rp3-4 juta/bulan.";
        }
        
        if (strpos($lowerMessage, 'halo') !== false || strpos($lowerMessage, 'hai') !== false) {
            return "Halo! 👋\n\nSaya adalah AI Assistant Properti Merah Putih.\n\nSaya bisa membantu Anda:\n" .
                   "• Mencari properti sesuai budget\n" .
                   "• Menghitung simulasi KPR\n" .
                   "• Memberikan rekomendasi properti\n\n" .
                   "Apa yang bisa saya bantu hari ini? 😊";
        }
        
        return "Maaf, saya belum bisa memahami pertanyaan Anda. 🙏\n\n" .
               "Coba tanyakan hal ini:\n" .
               "• 'Cari rumah budget 500 juta'\n" .
               "• 'Info KPR dan cicilan'\n" .
               "• 'Halo' untuk sapaan\n\n" .
               "Atau gunakan menu di atas untuk fitur lengkap!";
    }

    private function getBudgetRecommendation($budget)
    {
        $properties = Property::where('price', '<=', $budget)
            ->orderBy('price', 'desc')
            ->limit(3)
            ->get();
        
        if ($properties->isEmpty()) {
            return "Maaf, untuk budget Rp" . number_format($budget, 0, ',', '.') . 
                   " belum ada properti yang tersedia.\n\n" .
                   "💡 *Saran:*\n" .
                   "• Tingkatkan budget Anda\n" .
                   "• Cek properti lain di website kami\n\n" .
                   "Atau coba dengan budget yang lebih tinggi.";
        }
        
        $reply = "🏠 *Rekomendasi Properti Budget Rp" . number_format($budget, 0, ',', '.') . "*\n\n";
        
        foreach ($properties as $property) {
            $reply .= "✅ *{$property->title}*\n";
            $reply .= "📍 {$property->location}\n";
            $reply .= "💰 Rp" . number_format($property->price, 0, ',', '.') . "\n";
            $reply .= "🛏 {$property->bedroom} KT | 🚿 {$property->bathroom} KM | 📐 {$property->building_area} m²\n\n";
        }
        
        $reply .= "💡 Klik 'Lihat Detail' untuk info lengkap setiap properti!";
        
        return $reply;
    }
}