<?php
include "header.php";
include "../koneksi.php"; // Include database connection
include "../logic/functions.php"; // Include functions file

// Cek apakah pengguna sudah login dan memiliki level yang sesuai
if (!isset($_SESSION['level']) || $_SESSION['level'] != 1) {
    // Jika tidak, alihkan ke halaman beranda atau halaman lain
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_petugas = $_POST['nama_petugas'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Hash the password
    $level = $_POST['level'];

    try {
        // Panggil fungsi untuk menambahkan pengguna
        tambahPengguna($mysqli, $nama_petugas, $username, $password, $level);
        echo "<script>window.location.href = 'user_management.php?pesan=simpan'</script>";
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<div id="content">
    <div class="container mt-2">
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-header mt-2">
                <h3>Tambah User</h3>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" name="nama_petugas" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Level</label>
                        <select class="form-control" name="level" required>
                            <option value="1">Admin</option>
                            <option value="2">Petugas</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Add User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>