<?php
session_start();
$config = json_decode(file_get_contents('../helper/config.json'), true);
$valid_user = $config['users'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';

    if ($username === $valid_user) {
        $_SESSION['username'] = $username;
        header('Location: index');
        exit;
    } else {
        $error = "Token Access Invalid";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gobot.cx/Gobot.su</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4; /* Latar belakang lembut */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 300px;
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .input-container {
            position: relative; /* Untuk menempatkan label di atas input */
            margin-bottom: 20px;
            width: 100%; /* Memastikan input container mengambil lebar penuh */
        }
        input[type="text"] {
            width: calc(100% - 24px); /* Menyesuaikan lebar dengan padding */
            padding: 12px 10px;
            border: 2px solid #ccc;
            border-radius: 5px;
            font-size: 16px; /* Ukuran font yang lebih besar */
            transition: border-color 0.3s, box-shadow 0.3s;
            outline: none;
            background-color: #fff; /* Warna latar belakang input */
        }
        input[type="text"]:focus {
            border-color: #007bff; /* Warna border saat fokus */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Efek bayangan saat fokus */
        }
        .floating-label {
            position: absolute;
            left: 10px;
            top: 12px; /* Posisi label saat tidak fokus */
            font-size: 16px;
            color: #aaa;
            transition: 0.2s ease all;
            pointer-events: none;
        }
        input[type="text"]:focus + .floating-label,
        input[type="text"]:not(:placeholder-shown) + .floating-label {
            top: -10px; /* Posisi label saat fokus */
            left: 8px;
            font-size: 12px;
            color: #007bff; /* Warna label saat fokus */
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%; /* Tombol mengambil lebar penuh */
            transition: background-color 0.3s, transform 0.2s;
            font-weight: bold;
            font-size: 16px;
            margin-top: 10px; /* Menambahkan jarak atas */
        }
        button:hover {
            background-color: #0056b3; /* Warna saat hover */
            transform: scale(1.02); /* Efek zoom pada tombol saat hover */
        }
        .error-message {
            color: #dc3545;
            margin-top: 10px;
            font-size: 14px;
            display: none; /* Tersembunyi secara default */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Gobot Access</h1>
        <form method="POST">
            <div class="input-container">
                <input type="text" name="username" required placeholder="Input Token" />
            </div>
            <button type="submit">Login</button>
        </form>
            <?php if (!empty($error)): ?>
            <p class="error-message" style="display: block;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
    </div>
</body>
</html>
