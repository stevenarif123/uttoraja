<?php
include '../koneksi.php'; // Include file koneksi database

// Periksa apakah form telah disubmit
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $nama_lengkap = strtoupper($_POST['firstn']);
    $nomor_hp = $_POST['phone'];
    $tempat_lahir = strtoupper($_POST['tempat_lahir']);
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $ibu_kandung = strtoupper($_POST['ibu_kandung']);
    $nik = $_POST['nik'];
    $jurusan = $_POST['jurusan'];
    $agama = $_POST['agama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $pertanyaan = $_POST['pertanyaan'];


    // Query SQL untuk memasukkan data ke database
    $sql = "INSERT INTO pendaftar (nama_lengkap, nomor_hp, tempat_lahir, tanggal_lahir, ibu_kandung, nik, jurusan, agama, jenis_kelamin, pertanyaan) 
            VALUES ('$nama_lengkap', '$nomor_hp', '$tempat_lahir', '$tanggal_lahir', '$ibu_kandung', '$nik', '$jurusan', '$agama', '$jenis_kelamin', '$pertanyaan')";

    // Eksekusi query
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Pendaftaran berhasil!'); window.location.href = 'index.html'; </script>"; // Redirect ke halaman index.html atau halaman lain yang sesuai
        exit; //hentikan skrip setelah redirect.

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


// Perintah SQL untuk membuat tabel pendaftar:
/*
CREATE TABLE pendaftar (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(255) NOT NULL,
    nomor_hp VARCHAR(20) NOT NULL,
    tempat_lahir VARCHAR(255) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    ibu_kandung VARCHAR(255) NOT NULL,
    nik VARCHAR(50) NOT NULL,
    jurusan VARCHAR(255) NOT NULL,
    agama VARCHAR(50) NOT NULL,
    jenis_kelamin VARCHAR(10) NOT NULL,
    pertanyaan TEXT
);
*/
// Tutup koneksi
$conn->close();
?>