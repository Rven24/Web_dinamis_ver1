<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user information
$user_name = $_SESSION['user_name'] ?? 'User';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        .welcome-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 77, 64, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            transition: opacity 0.5s ease-in-out;
        }
        .welcome-content {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            text-align: center;
            max-width: 500px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        .welcome-content h1 {
            color: #004d40;
            margin-bottom: 20px;
        }
        .welcome-content p {
            color: #4e342e;
            margin-bottom: 30px;
        }
        #enter-dashboard {
            background-color: #00796b;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease-in-out;
        }
        #enter-dashboard:hover {
            background-color: #004d40;
        }
        .dashboard {
            transition: opacity 0.5s ease-in-out;
        }
        .hidden {
            opacity: 0;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div id="welcome-overlay" class="welcome-overlay">
        <div class="welcome-content">
            <h1>Welcome to the Dashboard, <?php echo htmlspecialchars($user_name); ?>!</h1>
            <p>We're glad to see you here. Get started by exploring your personalized dashboard.</p>
            <button id="enter-dashboard">Enter Dashboard</button>
        </div>
    </div>

    <div id="dashboard" class="dashboard hidden">
        <!-- Your existing dashboard content goes here -->
        <h1>Dashboard</h1>
        <p>Welcome, <?php echo htmlspecialchars($user_name); ?>! This is your dashboard.</p>
        <!-- Add more dashboard content as needed -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const welcomeOverlay = document.getElementById('welcome-overlay');
            const dashboard = document.getElementById('dashboard');
            const enterDashboardBtn = document.getElementById('enter-dashboard');

            enterDashboardBtn.addEventListener('click', () => {
                welcomeOverlay.style.opacity = '0';
                setTimeout(() => {
                    welcomeOverlay.style.display = 'none';
                    dashboard.classList.remove('hidden');
                }, 500);
            });

            // Check if it's the first visit
            if (!localStorage.getItem('dashboardVisited')) {
                welcomeOverlay.style.display = 'flex';
                localStorage.setItem('dashboardVisited', 'true');
            } else {
                welcomeOverlay.style.display = 'none';
                dashboard.classList.remove('hidden');
            }
        });
    </script>
</body>
</html>