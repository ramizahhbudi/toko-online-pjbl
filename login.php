<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/src/Auth.php';

use App\Auth;

$auth = new Auth(__DIR__ . '/data/users.json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $user = $auth->login(
            $_POST['email'],
            $_POST['password']
        );

        $_SESSION['user'] = $user;

        // CEK ROLE
        if ($_SESSION['user']['role'] == 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: index.php");
        }
        exit;

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%);
            min-height: 100vh;
        }
        
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(to right, #4e54c8 0%, #8f94fb 100%);
            color: white;
            padding: 1.5rem;
            text-align: center;
        }
        
        .form-control {
            border-radius: 12px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #4e54c8;
            box-shadow: 0 0 0 0.2rem rgba(78, 84, 200, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(to right, #4e54c8 0%, #8f94fb 100%);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(78, 84, 200, 0.4);
        }
        
        .alert {
            border-radius: 12px;
        }
    </style>
</head>
<body class="py-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            
            <div class="card shadow">
                
                <!-- Header Berwarna -->
                <div class="card-header">
                    <h3 class="mb-0 fw-bold">Login</h3>
                </div>
                
                <div class="card-body p-4">
                    
                    <?php if(isset($error)): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error) ?>
                    </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <input 
                                type="email" 
                                name="email" 
                                class="form-control" 
                                placeholder="Email"
                                required>
                        </div>
                        
                        <div class="mb-4">
                            <input 
                                type="password" 
                                name="password" 
                                class="form-control" 
                                placeholder="Password"
                                required>
                        </div>
                        
                        <button type="submit" class="btn btn-login text-white w-100">
                            LOGIN
                        </button>
                    </form>

                    <p class="mt-4 text-center mb-0">
                        Belum punya akun? 
                        <a href="register.php" class="text-decoration-none fw-bold" style="color: #4e54c8;">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>