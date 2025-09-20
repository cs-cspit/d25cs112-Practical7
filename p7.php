<?php
session_start();

$users = [
    "student1" => "password123",
    "student2" => "mypassword"
];

if (isset($_GET['logout'])) {
    session_destroy();
    setcookie("username", "", time() - 3600);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (!isset($_SESSION['username']) && isset($_COOKIE['username'])) {
    $_SESSION['username'] = $_COOKIE['username'];
}

$error = "";
if (isset($_POST['login'])) {
    $uname = $_POST['username'] ?? "";
    $pass = $_POST['password'] ?? "";
    $remember = isset($_POST['remember']);

    if (isset($users[$uname]) && $users[$uname] === $pass) {
        $_SESSION['username'] = $uname;

        if ($remember) {
            setcookie("username", $uname, time() + 86400 * 7);
        } else {
            setcookie("username", "", time() - 3600);
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $error = "&#10060; Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login/Logout System</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #fff5f5;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #c62828;
            padding: 25px;
            border-radius: 15px;
            width: 350px;
            color: white;
            text-align: center;
        }

        input[type=text], input[type=password] {
            width: 95%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 6px;
            border: none;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            background: #00ffff;
            color: #333;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #00cccc;
        }

        .error {
            color: #ffcccb;
            margin: 10px 0;
        }

        .welcome {
            font-size: 18px;
            margin-bottom: 15px;
        }

        label {
            display: flex;
            align-items: center;
            font-size: 14px;
        }

        label input {
            margin-right: 8px;
        }

        a {
            color: #fff;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <?php if (isset($_SESSION['username'])): ?>
        <div class="welcome">&#10004; Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</div>
        <a href="?logout=1">&#128274; Logout</a>
    <?php else: ?>
        <h2>&#127891; Student Login</h2>
        <?php if ($error) echo "<div class='error'>$error</div>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <label><input type="checkbox" name="remember"> Remember Me</label>
            <button type="submit" name="login">&#10148; Login</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
