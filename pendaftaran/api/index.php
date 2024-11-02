<?php
// Set header agar respon JSON
header('Content-Type: application/json');

// Include koneksi.php
include '../../koneksi.php';

// Inisialisasi array untuk menyimpan data
$data = [];

// Query untuk mendapatkan data mahasiswa
$query = "SELECT * FROM pendaftar";
$result = mysqli_query($conn, $query);

// Cek apakah ada hasil
if (mysqli_num_rows($result) > 0) {
    // Ambil setiap baris data
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'id' => $row['id'],
            'nama_lengkap' => $row['nama_lengkap'],
            'nomor_hp' => $row['nomor_hp'],
            'tempat_lahir' => $row['tempat_lahir'],
            'tanggal_lahir' => $row['tanggal_lahir'],
            'ibu_kandung' => $row['ibu_kandung'],
            'nik' => $row['nik'],
            'jurusan' => $row['jurusan'],
            'agama' => $row['agama'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'pertanyaan' => $row['pertanyaan']
        ];
    }
    // Mengembalikan data dalam format JSON
    echo json_encode($data);
} else {
    // Mengembalikan response jika tidak ada data
    echo json_encode(['message' => 'Tidak ada data mahasiswa.']);
}

// Tutup koneksi database
mysqli_close($conn);
?>
