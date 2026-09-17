<?php
session_start();
// Jika sudah login, arahkan ke dashboard
if (isset($_SESSION['loggedin'])) {
    header('Location: dashboard.php');
    exit;
}

// Logika untuk memproses login
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan file config dipanggil dengan path yang benar dari direktori 'admin'
    include '../includes/config.php'; 

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $username;
            $_SESSION['id'] = $id;
            header('Location: dashboard.php');
            exit;
        } else {
            $message = 'Username atau Password salah!';
        }
    } else {
        $message = 'Username atau Password salah!';
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Sekolah XYZ</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        :root {
            --primary-blue: #4a90e2;
            --blue-light: #6aa8ff;
            --blue-dark: #357abD;
            --text-dark: #2c3e50;
            --text-light: #f8f9fa;
            --shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--primary-blue), var(--blue-dark));
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: var(--text-dark);
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            perspective: 1000px;
        }

        .login-box {
            width: 100%;
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
            transform-style: preserve-3d;
            transition: var(--transition);
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-header {
            background: linear-gradient(to right, var(--primary-blue), var(--blue-light));
            padding: 30px;
            text-align: center;
            color: white;
            position: relative;
        }

        .login-header h2 {
            margin: 0;
            font-weight: 600;
            font-size: 26px;
            letter-spacing: 0.5px;
        }

        .login-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
        }

        .login-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
            color: var(--text-dark);
        }

        .form-control {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e0e6ed;
            border-radius: 8px;
            font-size: 15px;
            transition: var(--transition);
            background-color: #f8fafc;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
            background-color: white;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 40px;
            color: var(--primary-blue);
            font-size: 18px;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            border: none;
            background: linear-gradient(to right, var(--primary-blue), var(--blue-light));
            color: white;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .error-message {
            background: #fff0f0;
            color: #ff4d4f;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
            border-left: 4px solid #ff4d4f;
            display: flex;
            align-items: center;
        }

        .error-message i {
            margin-right: 10px;
            font-size: 18px;
        }

        .brand-logo {
            margin-bottom: 15px;
            font-size: 24px;
            font-weight: 700;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-logo i {
            margin-right: 10px;
            font-size: 28px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <div class="brand-logo">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Sekolah XYZ</span>
                </div>
                <h2>Admin Panel</h2>
            </div>
            <div class="login-body">
                <?php if($message): ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form action="index.php" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>