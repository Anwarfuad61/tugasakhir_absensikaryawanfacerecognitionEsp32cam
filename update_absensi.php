<?php

$servername = "localhost";
$username = "himmatul_ta_absensi";
$password = "L8SwRsmHKpaV8jGNe2j6";
$dbname = "himmatul_ta_absensi";

$koneksi = new mysqli($servername, $username, $password, $dbname);

if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

// Ambil tanggal hari ini
$tanggal = date('Y-m-d');

// Periksa apakah hari ini adalah hari Minggu
$hariIni = date('w'); // w mengembalikan nilai 0 untuk hari Minggu

if ($hariIni != 0) { // Jika hari ini bukan hari Minggu (nilai 0)
    // Ambil semua karyawan
    $sqlKaryawan = "SELECT karyawan_id FROM karyawan";
    $resultKaryawan = $koneksi->query($sqlKaryawan);

    // Loop melalui semua karyawan
    while ($karyawan = $resultKaryawan->fetch_assoc()) {
        $karyawan_id = $karyawan['karyawan_id'];
        $face_id = $karyawan['face_id'];

        // Periksa apakah ada data absensi untuk karyawan ini pada hari ini
        $sqlAbsensi = "SELECT * FROM absensi WHERE karyawan_id = '$karyawan_id' AND tgl = '$tanggal'";
        $resultAbsensi = $koneksi->query($sqlAbsensi);

        // Jika tidak ada data absensi, tambahkan entri Alpa
        if ($resultAbsensi->num_rows == 0) {
            $sqlInsert = "INSERT INTO absensi (karyawan_id, face_id, tgl, status) VALUES ('$karyawan_id','$face_id','$tanggal', 'Alpa')";
            $koneksi->query($sqlInsert);
        }
    }
}

$koneksi->close();
?>
