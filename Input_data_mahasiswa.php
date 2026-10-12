# OOP_Input_Data_Mahasiswa
<?php
// 1. Menyiapkan variabel dengan berbagai tipe data (String, Integer, Float, Boolean)
$nim = "";
$nama = "";
$fakultas = "";
$prodi = "";
$asal_sekolah = "";
$semester = 0;       // Integer
$ipk = 0.0;          // Float
$hobi = "";
$status_aktif = true; // Boolean

// 2. Function buatan sendiri + Percabangan (if/elseif/else)
// Fungsi untuk menentukan predikat IPK dan jatah maksimal SKS
function evaluasiAkademik($ipk) {
    if ($ipk >= 3.50) {
        return ["predikat" => "Cumlaude / Sangat Memuaskan", "max_sks" => 24];
    } elseif ($ipk >= 3.00) {
        return ["predikat" => "Memuaskan", "max_sks" => 22];
    } elseif ($ipk >= 2.50) {
        return ["predikat" => "Cukup", "max_sks" => 20];
    } else {
        return ["predikat" => "Perlu Bimbingan Akademik", "max_sks" => 18];
    }
}

// Fungsi untuk menentukan kategori tahapan studi berdasarkan semester
function cekTahapStudi($semester) {
    if ($semester <= 2) {
        return "Mahasiswa Tahun Pertama (Tingkat Dasar)";
    } elseif ($semester <= 6) {
        return "Mahasiswa Tingkat Menengah / Lanjut";
    } else {
        return "Mahasiswa Tingkat Akhir (Persiapan Skripsi/TA)";
    }
}

// Mengecek apakah form sudah dikirim melalui method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim          = $_POST["nim"];
    $nama         = $_POST["nama"];
    $fakultas     = $_POST["fakultas"];
    $prodi        = $_POST["prodi"];
    $asal_sekolah = $_POST["asal_sekolah"];
    $semester     = (int) $_POST["semester"]; // Casting ke Integer
    $ipk          = (float) $_POST["ipk"];    // Casting ke Float
    $hobi         = $_POST["hobi"];
    $status_aktif = isset($_POST["status_aktif"]) ? true : false; // Boolean

    // Memanggil function buatan sendiri
    $hasilEvaluasi = evaluasiAkademik($ipk);
    $tahapStudi    = cekTahapStudi($semester);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <!-- Perbaikan typo dari <tile> menjadi <title> -->
    <title>Data Mahasiswa</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 30px;
        }

        .container {
            width: 600px;
            margin: auto;
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        h1 {
            text-align: center;
            color: #234f7d;
            margin-bottom: 20px;
        }

        label {
            /* Perbaikan typo dari display: black menjadi display: block */
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .checkbox-group {
            margin-top: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-group label {
            margin: 0;
            font-weight: normal;
        }

        button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background-color: #234f7d;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #163652;
        }

        .hasil {
            margin-top: 30px;
            padding: 20px;
            background-color: #eef5fa;
            border-left: 5px solid #234f7d;
            border-radius: 8px;
        }

        .hasil h2 {
            margin-top: 0;
            color: #234f7d;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 8px;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: bold;
            background-color: #d1fae5;
            color: #065f46;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Input Data Mahasiswa</h1>

    <form method="POST">

        <label>NIM</label>
        <input type="text" name="nim" placeholder="Contoh: 2430511001" required>

        <label>Nama Mahasiswa</label>
        <input type="text" name="nama" placeholder="Masukkan nama lengkap" required>

        <label>Fakultas</label>
        <input type="text" name="fakultas" placeholder="Contoh: Fakultas Sains dan Teknologi" required>

        <label>Program Studi</label>
        <input type="text" name="prodi" placeholder="Contoh: Teknik Informatika" required>

        <label>Asal Sekolah</label>
        <input type="text" name="asal_sekolah" placeholder="Masukkan asal SMA/SMK/MA" required>

        <label>Semester</label>
        <select name="semester" required>
            <option value="">-- Pilih Semester --</option>
            <?php
            // 3. Menggunakan Perulangan (for loop) untuk membuat opsi Semester 1 - 8
            for ($i = 1; $i <= 8; $i++) {
                echo "<option value='$i'>Semester $i</option>";
            }
            ?>
        </select>

        <label>IPK Terakhir (Skala 0.00 - 4.00)</label>
        <input type="number" name="ipk" step="0.01" min="0" max="4.00" placeholder="Contoh: 3.75" required>

        <label>Hobi</label>
        <input type="text" name="hobi" placeholder="Pisahkan dengan koma jika lebih dari satu (opsional)">

        <div class="checkbox-group">
            <input type="checkbox" name="status_aktif" id="status_aktif" checked>
            <label for="status_aktif">Mahasiswa berstatus aktif pada semester ini</label>
        </div>

        <button type="submit">Simpan Data</button>

    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>

        <div class="hasil">

            <h2>Data & Evaluasi Mahasiswa</h2>

            <p><strong>NIM:</strong> <?= htmlspecialchars($nim) ?></p>
            <p><strong>Nama:</strong> <?= htmlspecialchars($nama) ?></p>
            <p><strong>Fakultas:</strong> <?= htmlspecialchars($fakultas) ?></p>
            <p><strong>Program Studi:</strong> <?= htmlspecialchars($prodi) ?></p>
            <p><strong>Asal Sekolah:</strong> <?= htmlspecialchars($asal_sekolah) ?></p>
            <p><strong>Semester:</strong> Semester <?= htmlspecialchars($semester) ?> (<em><?= $tahapStudi ?></em>)</p>
            <p><strong>IPK:</strong> <?= number_format($ipk, 2) ?></p>
            <p><strong>Predikat Akademik:</strong> <span class="badge"><?= $hasilEvaluasi["predikat"] ?></span></p>
            <p><strong>Beban SKS Maksimal:</strong> <?= $hasilEvaluasi["max_sks"] ?> SKS</p>
            <p><strong>Status Kemahasiswaan:</strong> <?= $status_aktif ? "Aktif" : "Cuti / Tidak Aktif" ?></p>
            <p><strong>Hobi:</strong> <?= !empty($hobi) ? htmlspecialchars($hobi) : "-" ?></p>

        </div>

    <?php } ?>

</div>

</body>
</html>
