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
    public function tambahTransaksi($tanggal, $total_harga, $uang, $kembalian, $id_customer = null)
    {
        global $mysqli; // Assuming you have a mysqli connection available
        $stmt = $mysqli->prepare("INSERT INTO transaksi (tanggal, total_harga, uang, kembalian, id_customer) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sddsi", $tanggal, $total_harga, $uang, $kembalian, $id_customer);
        $stmt->execute();
        return $mysqli->insert_id; // Return the ID of the newly created transaction
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
        // Ambil nama produk berdasarkan id_produk
        $stmt = $this->db->prepare("SELECT nama_produk FROM produk WHERE id_produk = ?");
        if (!$stmt) {
            throw new Exception("Gagal menyiapkan statement: " . $this->db->error);
        }

        // Bind parameter dan eksekusi
        $stmt->bind_param("i", $id_produk);
        $stmt->execute();
        $stmt->bind_result($nama_produk);
        $stmt->fetch();
        $stmt->close();

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
        $stmt->bind_param(
            "iii",
            $jumlah,
            $id_produk,
            $jumlah
        );
        $stmt->execute();

        // Cek apakah ada baris yang diubah (stok cukup)
        if ($stmt->affected_rows === 0) {
            throw new Exception("Stok produk: " . ucwords($nama_produk) . " tidak mencukupi!"); // Menggunakan nama produk
        }

        $stmt->close();
    }

    // Fungsi untuk menampilkan semua transaksi
    public function getTransaksi()
    {
        $result = $this->db->query("SELECT * FROM transaksi order by id_transaksi desc");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTransaksiByMonthAndYear($bulan, $tahun) {
        $stmt = $this->db->prepare("SELECT * FROM transaksi WHERE MONTH(tanggal) = ? AND YEAR(tanggal) = ?");
        $stmt->bind_param("ii", $bulan, $tahun);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTransaksiDetails($transaksiId)
    {
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $this->db->prepare("
        SELECT t.*, d.jumlah, d.harga, p.nama_produk, c.NamaPelanggan AS customer_name
        FROM transaksi t 
        JOIN detail_transaksi d ON t.id_transaksi = d.id_transaksi 
        JOIN produk p ON d.id_produk = p.id_produk 
        LEFT JOIN pelanggan c ON t.id_customer = c.PelangganID 
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
                $transaksiDetails['uang'] = $row['uang']; // Ambil uang
                $transaksiDetails['kembalian'] = $row['kembalian']; // Ambil kembalian
                $transaksiDetails['customer_name'] = $row['customer_name'] ?? "* tidak dicantumkan"; // Set default if NULL
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

    public function getCustomerName($pelangganId)
    {
        global $mysqli; // Assuming you have a mysqli connection available
        $stmt = $mysqli->prepare("SELECT NamaPelanggan FROM pelanggan WHERE PelangganID = ?");
        $stmt->bind_param("i", $pelangganId);
        $stmt->execute();
        $result = $stmt->get_result();
        $customer = $result->fetch_assoc();
        return $customer ? $customer['NamaPelanggan'] : null;
    }
}
