<?php
$namaBulan = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
];

// =============== add customer
function tambahPelanggan($mysqli, $nama_pelanggan, $alamat, $nomor_telepon)
{
    // Insert customer into the database
    $stmt = $mysqli->prepare("INSERT INTO pelanggan (NamaPelanggan, Alamat, NomorTelepon) VALUES (?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Gagal menyiapkan statement: " . $mysqli->error);
    }

    $stmt->bind_param("sss", $nama_pelanggan, $alamat, $nomor_telepon);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        throw new Exception("Gagal menambahkan pelanggan.");
    }

    $stmt->close();
}

// =============== add user
function tambahPengguna($mysqli, $nama_petugas, $username, $password, $level)
{
    // Insert user into the database
    $stmt = $mysqli->prepare("INSERT INTO petugas (nama_petugas, username, password, level) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Gagal menyiapkan statement: " . $mysqli->error);
    }

    $stmt->bind_param("sssi", $nama_petugas, $username, $password, $level);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        throw new Exception("Gagal menambahkan pengguna.");
    }

    $stmt->close();
}

// get data customer
function ambilDataPelanggan($mysqli, $pelanggan_id = null)
{
    if ($pelanggan_id) {
        // Ambil data pelanggan berdasarkan ID
        $stmt = $mysqli->prepare("SELECT * FROM pelanggan WHERE PelangganID = ?");
        $stmt->bind_param("i", $pelanggan_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("Pelanggan tidak ditemukan.");
        }

        return $result->fetch_assoc();
    } else {
        // Ambil semua data pelanggan
        $query = "SELECT * FROM pelanggan";
        $result = $mysqli->query($query);

        if (!$result) {
            throw new Exception("Gagal mengambil data pelanggan: " . $mysqli->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC); // Mengembalikan semua pelanggan sebagai array
    }
}

// get data user
function ambilDataPetugas($mysqli, $id_petugas = null)
{
    if ($id_petugas) {
        // Ambil data petugas berdasarkan ID
        $stmt = $mysqli->prepare("SELECT * FROM petugas WHERE id_petugas = ?");
        $stmt->bind_param("i", $id_petugas);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("Petugas tidak ditemukan.");
        }

        return $result->fetch_assoc();
    } else {
        // Ambil semua data petugas
        $query = "SELECT * FROM petugas";
        $result = $mysqli->query($query);

        if (!$result) {
            throw new Exception("Gagal mengambil data petugas: " . $mysqli->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC); // Mengembalikan semua petugas sebagai array
    }
}

// get data produk
function ambilDataProduk($mysqli)
{
    $query = "SELECT p.*, k.nama_kategori FROM produk p LEFT JOIN kategori_produk k ON p.id_kategori = k.id_kategori order by p.id_produk desc";
    $result = $mysqli->query($query);

    if (!$result) {
        throw new Exception("Gagal mengambil data produk: " . $mysqli->error);
    }

    return $result;
}
function ambilDataCategory($mysqli)
{
    $query = "SELECT * FROM kategori_produk ORDER BY id_kategori DESC";
    $result = $mysqli->query($query);

    if (!$result) {
        throw new Exception("Gagal mengambil data produk: " . $mysqli->error);
    }

    return $result;
}

function ambilDataProdukByKategori($mysqli, $id_kategori)
{
    $stmt = $mysqli->prepare("
        SELECT p.*, k.nama_kategori 
        FROM produk p 
        JOIN kategori_produk k ON p.id_kategori = k.id_kategori 
        WHERE p.id_kategori = ?
    ");
    $stmt->bind_param("i", $id_kategori);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        throw new Exception("Tidak ada produk ditemukan untuk kategori ini.");
    }
}

// Get transaction data
function ambilDetailTransaksi($mysqli, $transaksiId)
{
    // Prepare the SQL statement
    $stmt = $mysqli->prepare("
        SELECT t.id_transaksi, t.tanggal, t.total_harga, p.nama_produk, dt.jumlah, p.harga
        FROM transaksi t
        JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
        JOIN produk p ON dt.id_produk = p.id_produk
        WHERE t.id_transaksi = ?
    ");

    // Bind the parameter
    $stmt->bind_param("i", $transaksiId);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows === 0) {
        throw new Exception("Transaksi tidak ditemukan.");
    }

    // Initialize an array to hold the transaction details
    $transaksi = [
        'id_transaksi' => null,
        'tanggal' => null,
        'total_harga' => 0,
        'produk' => []
    ];

    // Fetch the results
    while ($row = $result->fetch_assoc()) {
        // Populate the transaction details
        if ($transaksi['id_transaksi'] === null) {
            $transaksi['id_transaksi'] = $row['id_transaksi'];
            $transaksi['tanggal'] = $row['tanggal'];
            $transaksi['total_harga'] = $row['total_harga'];
        }

        // Create an array for the product details
        $produk = [
            'nama_produk' => $row['nama_produk'],
            'jumlah' => $row['jumlah'],
            'harga' => $row['harga'],
        ];

        // Append the product to the transaction's product list
        $transaksi['produk'][] = $produk;
    }

    // Return the transaction details
    return $transaksi;
}

function ambilDataDetailTransaksiBulanan($mysqli, $bulan, $tahun)
{
    $stmt = $mysqli->prepare("
        SELECT p.nama_produk, SUM(dt.jumlah) AS total_jumlah, p.harga
        FROM detail_transaksi dt
        JOIN produk p ON dt.id_produk = p.id_produk
        JOIN transaksi t ON dt.id_transaksi = t.id_transaksi
        WHERE MONTH(t.tanggal) = ? AND YEAR(t.tanggal) = ?
        GROUP BY p.id_produk
    ");
    $stmt->bind_param("ii", $bulan, $tahun);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function ambilDataDetailTransaksiPerBulan($mysqli, $tahun)
{
    $stmt = $mysqli->prepare("SELECT MONTH(tanggal) AS bulan, SUM(total_harga) AS total FROM transaksi WHERE YEAR(tanggal) = ? GROUP BY bulan");
    $stmt->bind_param("i", $tahun);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[$row['bulan']] = $row;
    }

    return $data;
}


function ambilDataDetailTransaksiHarian($mysqli, $tahun, $bulan, $tanggal)
{
    $stmt = $mysqli->prepare("
        SELECT p.nama_produk, SUM(dt.jumlah) AS total_jumlah, p.harga
        FROM detail_transaksi dt
        JOIN produk p ON dt.id_produk = p.id_produk
        JOIN transaksi t ON dt.id_transaksi = t.id_transaksi
        WHERE YEAR(t.tanggal) = ? AND MONTH(t.tanggal) = ? AND DAY(t.tanggal) = ?
        GROUP BY p.id_produk
    ");
    $stmt->bind_param("iii", $tahun, $bulan, $tanggal);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}


// store product
function simpanProduk($mysqli, $namaProduk, $harga, $stok, $idKategori)
{
    // Persiapkan statement untuk menyimpan produk
    $stmt = $mysqli->prepare("INSERT INTO produk (nama_produk, harga, stok, id_kategori) VALUES (?, ?, ?, ?)");

    // Bind parameter: 's' untuk string, 'd' untuk double, 'i' untuk integer
    $stmt->bind_param("sdii", $namaProduk, $harga, $stok, $idKategori);

    // Eksekusi statement
    $result = $stmt->execute();

    // Cek apakah eksekusi berhasil
    if (!$result) {
        throw new Exception("Gagal menyimpan produk: " . $stmt->error);
    }

    return $result; // Kembalikan hasil eksekusi
}

function simpanKategri($mysqli, $nama_kategori)
{
    $stmt = $mysqli->prepare("INSERT INTO kategori_produk (nama_kategori) VALUES (?)");
    $stmt->bind_param("s", $nama_kategori); // 's' untuk string, 'd' untuk double, 'i' untuk integer
    $result = $stmt->execute();

    if (!$result) {
        throw new Exception("Gagal menyimpan kategori: " . $stmt->error);
    }

    return $result;
}

// update customer
function updatePelanggan($mysqli, $pelanggan_id, $nama_pelanggan, $alamat, $nomor_telepon)
{
    $stmt = $mysqli->prepare("UPDATE pelanggan SET NamaPelanggan = ?, Alamat = ?, NomorTelepon = ? WHERE PelangganID = ?");
    $stmt->bind_param("sssi", $nama_pelanggan, $alamat, $nomor_telepon, $pelanggan_id);
    $stmt->execute();
}

// update user
function updatePetugas($mysqli, $id_petugas, $nama_petugas, $username, $password, $level)
{
    $stmt = $mysqli->prepare("UPDATE petugas SET nama_petugas = ?, username = ?, password = ?, level = ? WHERE id_petugas = ?");
    $stmt->bind_param("ssssi", $nama_petugas, $username, $password, $level, $id_petugas);
    $stmt->execute();
}

// update product
function updateProduk($mysqli, $produkID, $namaProduk, $harga, $stok, $idKategori)
{
    // Persiapkan statement untuk memperbarui produk
    $stmt = $mysqli->prepare("UPDATE produk SET nama_produk = ?, harga = ?, stok = ?, id_kategori = ? WHERE id_produk = ?");

    // Bind parameter: 's' untuk string, 'd' untuk double, 'i' untuk integer
    $stmt->bind_param("sdiis", $namaProduk, $harga, $stok, $idKategori, $produkID);

    // Eksekusi statement
    $result = $stmt->execute();

    // Cek apakah eksekusi berhasil
    if (!$result) {
        throw new Exception("Gagal memperbarui produk: " . $stmt->error);
    }

    return $result; // Kembalikan hasil eksekusi
}

function updateKategori($mysqli, $kategoriID, $namaKategori)
{
    $stmt = $mysqli->prepare("UPDATE kategori_produk SET nama_kategori = ? WHERE id_kategori = ?");
    $stmt->bind_param("si", $namaKategori, $kategoriID); // 's' untuk string, 'd' untuk double, 'i' untuk integer
    $result = $stmt->execute();

    if (!$result) {
        throw new Exception("Gagal memperbarui kategori: " . $stmt->error);
    }

    return $result;
}

// delete customer
function hapusPelanggan($mysqli, $pelanggan_id)
{
    $stmt = $mysqli->prepare("DELETE FROM pelanggan WHERE PelangganID = ?");
    if (!$stmt) {
        throw new Exception("Gagal menyiapkan statement: " . $mysqli->error);
    }

    $stmt->bind_param("i", $pelanggan_id);
    $stmt->execute();
    $stmt->close();
}

// delete user
function hapusPetugas($mysqli, $id_petugas)
{
    $stmt = $mysqli->prepare("DELETE FROM petugas WHERE id_petugas = ?");
    if (!$stmt) {
        throw new Exception("Gagal menyiapkan statement: " . $mysqli->error);
    }

    $stmt->bind_param("i", $id_petugas);
    $stmt->execute();
    $stmt->close();
}

// delete product
function hapusProduk($mysqli, $id_produk)
{
    $stmt = $mysqli->prepare("DELETE FROM produk WHERE id_produk = ?");
    $stmt->bind_param("i", $id_produk);
    $result = $stmt->execute();

    if (!$result) {
        throw new Exception("Gagal menghapus produk: " . $stmt->error);
    }

    return $result;
}

function hapusKategori($mysqli, $id_kategori)
{
    $stmt = $mysqli->prepare("DELETE FROM kategori_produk WHERE id_kategori = ?");
    $stmt->bind_param("i", $id_kategori);
    $result = $stmt->execute();

    if (!$result) {
        throw new Exception("Gagal menghapus kategori: " . $stmt->error);
    }

    return $result;
}


