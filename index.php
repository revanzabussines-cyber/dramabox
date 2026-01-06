<?php
// --- SETUP API ---
// Kita tembak endpoint VIP yang lu kasih tadi
$url = "https://dramabox.sansekai.my.id/api/dramabox/vip";

// --- FUNGSI CURL (ALAT PENYEDOT DATA) ---
function tembakAPI($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // Pura-pura jadi Browser biar gak diblokir
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'); 
    $output = curl_exec($ch);
    curl_close($ch);
    return json_decode($output, true); // Ubah JSON jadi Array PHP
}

// --- JALANKAN PROSES ---
$data = tembakAPI($url);
$daftar_drama = [];

// Cek apakah ada data 'bookList' kayak di gambar lu 
if (isset($data['bookList'])) {
    $daftar_drama = $data['bookList'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dramabox VIP by Bro</title>
    <style>
        /* GAYA GELAP ala NETFLIX */
        body { background-color: #111; color: white; font-family: sans-serif; margin: 0; padding: 20px; }
        h1 { color: #E50914; text-align: center; text-transform: uppercase; letter-spacing: 2px; }
        
        .container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background: #222;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.2s;
            position: relative;
        }

        .card:hover { transform: scale(1.05); cursor: pointer; border: 1px solid #fff; }
        
        .card img {
            width: 100%;
            height: 220px;
            object-fit: cover; /* Biar gambar gak penyok */
        }

        .info { padding: 10px; }
        .judul { font-size: 14px; font-weight: bold; margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .eps { font-size: 11px; color: #aaa; }
        .badge {
            position: absolute; top: 5px; right: 5px;
            background: #E50914; color: white;
            font-size: 10px; padding: 3px 6px; border-radius: 4px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h1>🔥 VIP COLLECTION 🔥</h1>

    <div class="container">
        <?php if (!empty($daftar_drama)): ?>
            <?php foreach ($daftar_drama as $drama): ?>
                <div class="card">
                    <img src="<?php echo $drama['coverWap']; ?>" alt="Poster" loading="lazy">
                    
                    <div class="badge">VIP</div>
                    
                    <div class="info">
                        <div class="judul"><?php echo $drama['bookName']; ?></div>
                        
                        <div class="eps"><?php echo $drama['chapterCount']; ?> Episode</div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="text-align:center; grid-column: 1/-1;">
                <h3>⚠️ Data Kosong atau Limit API Habis</h3>
                <p>Coba refresh 1 menit lagi (Server cuma bolehin 15x hit/menit).</p>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
