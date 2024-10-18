<?php
include "header.php";
include "navbar.php";
include "../koneksi.php"; // Include database connection

if (isset($_GET['id'])) {
    $id_petugas = $_GET['id'];

    // Fetch user data from the database
    $stmt = $mysqli->prepare("SELECT * FROM petugas WHERE id_petugas = ?");
    $stmt->bind_param("i", $id_petugas);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_petugas = $_POST['nama_petugas'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $level = $_POST['level'];

    // Update user in the database
    $stmt = $mysqli->prepare("UPDATE petugas SET nama_petugas = ?, username = ?, password = ?, level = ? WHERE id_petugas = ?");
    $stmt->bind_param("ssssi", $nama_petugas, $username, $password, $level, $id_petugas);
    $stmt->execute();

    header("Location: user_management.php?pesan=update");
    exit();
}
?>

<div class="container mt-4">
    <h2>Edit User</h2>
    <form method="post" action="">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="nama_petugas" value="<?php echo $user['nama_petugas']; ?>" required>
        </div>
        <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" name="username" value="<?php echo $user['username']; ?>" required>
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

<?php
include "footer.php";
?>