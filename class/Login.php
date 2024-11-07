<?php
// Mengimpor koneksi.php untuk mendapatkan koneksi database
require '../koneksi.php';

// Mendefinisikan kelas User
class Login
{
    // Properti private untuk menyimpan username, password, dan level pengguna
    private $nama_petugas;
    private $username;
    private $password;
    private $level;

    // Konstruktor untuk menginisialisasi objek User dengan username dan password
    public function __construct($username, $password)
    {
        $this->username = htmlspecialchars($username);
        // Menggunakan md5 untuk mengenkripsi password
        $this->password = htmlspecialchars(md5($password));
    }

    // Metode untuk mengautentikasi pengguna dengan memeriksa username dan password di database
    public function authenticate($login)
    {
        // Menyiapkan query untuk memilih data pengguna dari tabel petugas
        $query = "SELECT * FROM petugas WHERE username='$this->username' AND password='$this->password'";
        // Menjalankan query
        $result = mysqli_query($login, $query);
        // Mengambil hasil query sebagai array asosiatif
        $data = mysqli_fetch_assoc($result);

        // Jika data ditemukan, set level dan kembalikan true
        if ($data) {
            $this->level = $data['level'];
            $this->nama_petugas = $data['nama_petugas'];
            return true;
        } else {
            // Jika tidak ditemukan, kembalikan false
            return false;
        }
    }

    // Metode untuk memeriksa apakah pengguna adalah admin
    public function isAdmin()
    {
        return $this->level == "1"; // Mengembalikan true jika level adalah 1
    }

    // Metode untuk memeriksa apakah pengguna adalah pegawai
    public function isPegawai()
    {
        return $this->level == "2"; // Mengembalikan true jika level adalah 2
    }

    // Metode getter untuk mengakses username
    public function getUsername()
    {
        return $this->username;
    }

    // Metode getter untuk mengakses nama petugas
    public function getName()
    {
        return $this->nama_petugas;
    }

    // Metode getter untuk mengakses level
    public function getLevel()
    {
        return $this->level;
    }
}

// Membuat objek User baru dengan username dan password yang diterima dari form
$user = new Login($_POST['username'], $_POST['password']);

// Mengautentikasi pengguna
if ($user->authenticate($mysqli)) {
    // Memulai session
    session_start();

    // Mengatur variabel session menggunakan metode getter
    $_SESSION['username'] = $user->getUsername();
    $_SESSION['nama_petugas'] = $user->getName();
    $_SESSION['level'] = $user->getLevel();

    // Mengalihkan pengguna ke dashboard yang sesuai berdasarkan level
    if ($user->isAdmin()) {
        header("location:../view/index.php"); // Menuju dashboard admin
    } elseif ($user->isPegawai()) {
        header("location:../view/index.php"); // Menuju dashboard pegawai
    } else {
        header("location:index.php?pesan=gagal"); // Jika tidak ada level yang sesuai
    }
} else {
    // Jika autentikasi gagal, mengalihkan kembali ke halaman login dengan pesan gagal
    header("location:index.php?pesan=gagal");
}
