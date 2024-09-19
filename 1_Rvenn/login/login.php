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

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST["username"]);
    $password = $_POST["password"];
    
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare(query: $sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            header("Location: dashboard_admin.php");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }
    
    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .toggle-link {
            margin-top: 20px;
            cursor: pointer;
            color: #00796b;
            text-decoration: none;
        }

        .toggle-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container" id="form-container">
        <div class="form-header" id="form-header">
            <h2>Login</h2>
        </div>
        <form id="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" id="username" name="username" placeholder="Username" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <a href="register.php" class="form-link" id="toggle-form">Daftar</a>
        </form>
    </div>
</body>
</html>
