<?php
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
    $query = "SELECT * FROM produk ORDER BY id_produk DESC";
    $result = $mysqli->query($query);

    if (!$result) {
        throw new Exception("Gagal mengambil data produk: " . $mysqli->error);
    }

    return $result;
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



// store product
function simpanProduk($mysqli, $namaProduk, $harga, $stok)
{
    $stmt = $mysqli->prepare("INSERT INTO produk (nama_produk, harga, stok) VALUES (?, ?, ?)");
    $stmt->bind_param("sdi", $namaProduk, $harga, $stok); // 's' untuk string, 'd' untuk double, 'i' untuk integer
    $result = $stmt->execute();

    if (!$result) {
        throw new Exception("Gagal menyimpan produk: " . $stmt->error);
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
function updateProduk($mysqli, $produkID, $namaProduk, $harga, $stok)
{
    $stmt = $mysqli->prepare("UPDATE produk SET nama_produk = ?, harga = ?, stok = ? WHERE id_produk = ?");
    $stmt->bind_param("sdii", $namaProduk, $harga, $stok, $produkID); // 's' untuk string, 'd' untuk double, 'i' untuk integer
    $result = $stmt->execute();

    if (!$result) {
        throw new Exception("Gagal memperbarui produk: " . $stmt->error);
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
