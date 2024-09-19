<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "0.1_db";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_SESSION['registration_success'])) {
    echo '<div class="success-message" style="color: green; margin-bottom: 10px;">Registration successful! Please log in.</div>';
    unset($_SESSION['registration_success']);
}


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST["new-username"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $password = $_POST["new-password"];
    
    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long";
    } else {
        $checkSql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $checkStmt = $conn->prepare(query: $checkSql);
        $checkStmt->bind_param("ss", $username, $email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        
        if ($checkResult->num_rows > 0) {
            $error = "Username or email already exists";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertSql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("sss", $username, $email, $hashedPassword);
            
            if ($insertStmt->execute()) {
                $_SESSION['registration_success'] = true;
                header("Location: login.php");
                exit();
            } else {
                $error = "Registration failed. Please try again.";
            }
            
            $insertStmt->close();
        }
        
        $checkStmt->close();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <div class="form-container">
    <div class="form-header">
        <h2>Registrasi</h2>
    <style>
        body {
            font-family: 'Arial, sans-serif';
            background-color: #e0f7fa;
            color: #4e342e;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
        }

        .form-header {
            background-color: #004d40;
            color: white;
            padding: 15px;
            border-radius: 12px 12px 0 0;
            margin-bottom: 30px;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: #00796b;
            outline: none;
        }

        button {
            background-color: #00796b;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: calc(100% - 20px);
            margin: 10px 0;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #004d40;
        }

        .form-link {
            color: #004d40;
            text-decoration: none;
            display: block;
            margin-top: 15px;
        }

        .form-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    </div>
    <?php if (isset($error)): ?>
        <div class="error-message" style="color: red; margin-bottom: 10px;">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" id="new-username" name="new-username" placeholder="Username" required>
        <input type="email" id="email" name="email" placeholder="Email" required>
        <input type="password" id="new-password" name="new-password" placeholder="Password" required>
        <button type="submit">Daftar</button>
        <a href="login.php" class="form-link">Sudah punya akun? Login di sini</a>
    </form>
    </div>
</body>
</html>
