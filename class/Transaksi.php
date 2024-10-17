<?php
class Transaksi
{
    private $db;

    // Koneksi database diinisialisasi lewat konstruktor
    public function __construct($database)
    {
        $this->db = $database;
    }

    // Fungsi untuk menambah transaksi
    public function tambahTransaksi($tanggal, $total_harga)
    {
        $stmt = $this->db->prepare("INSERT INTO transaksi (tanggal, total_harga) VALUES (?, ?)");
        $stmt->bind_param("si", $tanggal, $total_harga);
        $stmt->execute();
        return $this->db->insert_id; // Mengembalikan ID transaksi terakhir
    }

    // Fungsi untuk menambah detail transaksi
    public function tambahDetailTransaksi($id_transaksi, $id_produk, $jumlah, $harga)
    {
        $stmt = $this->db->prepare("INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah, harga) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiii", $id_transaksi, $id_produk, $jumlah, $harga);
        $stmt->execute();
    }

    // Fungsi untuk mengurangi stok produk
    public function kurangiStok($id_produk, $jumlah)
    {
        // Kurangi stok hanya jika stok mencukupi
        $stmt = $this->db->prepare("
            UPDATE produk 
            SET stok = stok - ? 
            WHERE id_produk = ? AND stok >= ?
        ");
        if (!$stmt) {
            throw new Exception("Gagal menyiapkan statement: " . $this->db->error);
        }

        // Bind parameter dan eksekusi
        $stmt->bind_param("iii", $jumlah, $id_produk, $jumlah);
        $stmt->execute();

        // Cek apakah ada baris yang diubah (stok cukup)
        if ($stmt->affected_rows === 0) {
            throw new Exception("Stok produk ID: $id_produk tidak mencukupi atau produk tidak ditemukan!");
        }

        $stmt->close();
    }

    // Fungsi untuk menampilkan semua transaksi
    public function getTransaksi()
    {
        $result = $this->db->query("SELECT * FROM transaksi order by id_transaksi desc");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Method to get transaction details by ID
    // Method to get transaction details by ID
    public function getTransaksiDetails($transaksiId)
    {
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $this->db->prepare("
        SELECT t.*, d.jumlah, d.harga, p.nama_produk 
        FROM transaksi t 
        JOIN detail_transaksi d ON t.id_transaksi = d.id_transaksi 
        JOIN produk p ON d.id_produk = p.id_produk 
        WHERE t.id_transaksi = ?
    ");
        $stmt->bind_param("i", $transaksiId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Initialize an array to hold the transaction details
        $transaksiDetails = [
            'produk' => []
        ];

        // Fetch the transaction details and items
        while ($row = $result->fetch_assoc()) {
            // If it's the first row, get the main transaction details
            if (empty($transaksiDetails['id_transaksi'])) {
                $transaksiDetails['id_transaksi'] = $row['id_transaksi'];
                $transaksiDetails['tanggal'] = $row['tanggal'];
                $transaksiDetails['total_harga'] = $row['total_harga'];
            }

            // Add each item to the produk array
            $transaksiDetails['produk'][] = [
                'nama_produk' => $row['nama_produk'],
                'jumlah' => $row['jumlah'],
                'harga' => $row['harga']
            ];
        }

        // Return the complete transaction details
        return $transaksiDetails;
    }
}
