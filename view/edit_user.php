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

if (isset($_GET['id'])) {
    $id_petugas = $_GET['id'];

    try {
        // Ambil data petugas dari database
        $user = ambilDataPetugas($mysqli, $id_petugas);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_petugas = $_POST['nama_petugas'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Hash the password
    $level = $_POST['level'];

    try {
        // Update user in the database
        updatePetugas($mysqli, $id_petugas, $nama_petugas, $username, $password, $level);
        echo "<script>window.location.href = 'user_management.php?pesan=update'</script>";
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}
?>
<div id="content">
    <div class="container mt-2">
        <a href="user_management.php" class="btn btn-primary btn-sm">
            Kembali
        </a>
        <div class="card shadow-lg border-0 my-4">
            <div class="card-header mt-2">
                <h3>Edit User</h3>
            </div>
            <div class="card-body">
                <a href="user_management.php" class="btn btn-primary btn-sm">
                    Kembali
                </a>
                <form method="post" action="">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="nama_petugas" value="<?php echo htmlspecialchars($user['nama_petugas']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group">
                        <label>Level</label>
                        <select class="form-control" name="level" required>
                            <option value="1" <?php echo $user['level'] == 1 ? 'selected' : ''; ?>>Admin</option>
                            <option value="2" <?php echo $user['level'] == 2 ? 'selected' : ''; ?>>Pegawai</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Perbarui Pengguna</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>