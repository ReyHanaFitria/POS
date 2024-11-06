<!DOCTYPE html>
<html>

<head>
    <title>Ujikom Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Root */
        :root {
            --gradient-1: #FFB5E8;
            --gradient-2: #B8E1FF;
            --gradient-3: #AFF8DB;
        }

        /* Body */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(-45deg, var(--gradient-1), var(--gradient-2), var(--gradient-3));
            background-size: 1000% 1000%;
            animation: gradient 15s ease infinite;
        }

        /* Animasikan latar belakang gradien */
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Card Glassmorphism */
        .card {
            background: rgba(255, 255, 255, 0.4);
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Tombol */
        .btn-primary {
            background-color: #b8d8d8;
            border-color: #b8d8d8;
            color: #3b6978;
        }

        .btn-primary:hover {
            background-color: #9dc5c3;
            border-color: #9dc5c3;
        }

        /* Gambar Responsif */
        .login-image {
            width: 100%;
            max-width: 300px;
            margin: auto;
            display: block;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="card p-4 col-lg-8">
                <div class="text-center mb-4">
                    <h3>Login</h3>
                </div>
                <?php
                if (isset($_GET['pesan']) && $_GET['pesan'] == "gagal") {
                    echo "<div class='alert alert-danger text-center'>Username dan Password tidak sesuai!</div>";
                }
                ?>
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <form method="post" action="class/Login.php">
                            <div class="form-group mb-3">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <button class="btn btn-primary form-control" type="submit">Login</button>
                        </form>
                    </div>
                    <div class="col-lg-6 text-center">
                        <img src="assets/logopink.png" class="login-image" alt="Logo">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>