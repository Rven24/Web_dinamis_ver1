<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) ) {
    header("Location: login.php");
    exit();
}

// You would typically fetch this data from your database
$totalUsers = 1;
$newUsers = 1;
$activeUsers = 1;

$recentUsers = [
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            padding: 20px;
        }
        header {
            background: #35424a;
            color: white;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #e8491d 3px solid;
        }
        header h1 {
            margin: 0;
            text-align: center;
            padding-bottom: 10px;
        }
        .dashboard-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .stat-box {
            background: #fff;
            padding: 20px;
            text-align: center;
            flex: 1;
            margin: 0 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #35424a;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <header>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <a href="logout.php" style="float: right; color: white; text-decoration: none;">Logout</a>
    </div>
    </header>
    <div class="container">
        <h2>Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        
        <div class="dashboard-stats">
            <div class="stat-box">
                <h3>Total Pengguna</h3>
                <p><?php echo $totalUsers; ?></p>
            </div>
            <div class="stat-box">
                <h3>Pengguna Baru</h3>
                <p><?php echo $newUsers; ?></p>
            </div>
            <div class="stat-box">
                <h3>Pengguna Aktif</h3>
                <p><?php echo $activeUsers; ?></p>
            </div>
        </div>

        <h3>Pengguna Terbaru</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Tanggal Registrasi</th>
            </tr>
            <?php foreach ($recentUsers as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['registered_date']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
