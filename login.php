<?php
session_start();
include 'koneksi.php';

$error = '';

// Kalau form dikirim
if (isset($_POST['login'])) {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $password = trim($_POST['password']);

    // Proses login
    $query = $conn->query("SELECT * FROM users WHERE username = '$username'");
    if ($query && $query->num_rows > 0) {
        $user = $query->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header('Location: index.php');
            exit;
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            height: 100vh;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: rgba(10, 30, 66, 0.85); /* Navy transparan */
            padding: 40px 30px;
            border-radius: 20px;
            width: 380px;
            max-width: 90%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            text-align: center;
            color: #fff;
        }

        .login-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 25px;
            color: #f1f5f9;
        }

        .login-form-group {
            margin-bottom: 20px;
        }

        .login-input {
            width: 100%;
            padding: 12px 15px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.5);
            background: rgba(255,255,255,0.1);
            color: #fff;
            font-size: 14px;
            transition: 0.3s;
        }

        .login-input::placeholder {
            color: rgba(255,255,255,0.7);
        }

        .login-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: rgba(255,255,255,0.2);
            box-shadow: 0 0 0 3px rgba(59,130,246,0.3);
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            background: linear-gradient(135deg, #0a1e42 0%, #3b82f6 100%);
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-btn:hover {
            box-shadow: 0 5px 15px rgba(10,30,66,0.5);
        }

        .login-error {
            background: rgba(220, 38, 38, 0.8);
            color: #fff;
            padding: 12px 15px;
            border-radius: 12px;
            font-weight: 500;
            margin-bottom: 20px;
            border-left: 4px solid #dc2626;
            text-align: left;
        }

        @media(max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }

            .login-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2 class="login-title">Login</h2>

    <?php if (!empty($error)): ?>
        <div class="login-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" class="login-form">
        <div class="login-form-group">
            <input type="text" name="username" class="login-input" placeholder="Username" required>
        </div>

        <div class="login-form-group">
            <input type="password" name="password" class="login-input" placeholder="Password" required>
        </div>

        <div class="login-form-group">
            <button type="submit" name="login" class="login-btn">Login</button>
        </div>
    </form>
</div>

</body>
</html>
