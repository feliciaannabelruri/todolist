<?php
session_start();
include('conn.php'); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture username and password from the login form
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Create connection (use connection from your conn.php instead if already connected)
    $servername = "localhost";   
    $username = "u571101154_todowish";  
    $password = "Todowish123";  
    $dbname = "u571101154_todowish";  

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL query to fetch the user based on the entered username
    $stmt = $conn->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
    $stmt->bind_param('s', $input_username); // Bind the actual input username
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password entered by the user against the hashed password in the database
        if (password_verify($input_password, $user['password'])) {
            // Password is correct, start the session
            $_SESSION['user_id'] = $user['id']; // Store user ID in session
            header('Location: index.php'); // Redirect to the main page
            exit(); // Stop further execution
        } else {
            // Password is incorrect
            echo 'Password salah!';
        }
    } else {
        // Username not found in the database
        echo 'Pengguna tidak ditemukan!';
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='css/bootstrap.min.css'>
    <title>Login</title>
</head>
<style>
    /* CSS untuk halaman login */

body {
    font-family: 'Comic Sans MS', cursive, sans-serif;
    background-color: #f0f8ff;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    background-color: #ffffff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
    color: #333333;
    text-align: center;
}

.form-group {
    margin-bottom: 15px;
}

label {
    color: #666666;
}

.form-control {
    border-radius: 5px;
    border: 1px solid #cccccc;
    padding: 10px;
}

.btn-primary {
    background-color: #ff69b4; /* Warna pink cerah */
    border-color: #ff69b4;
    color: #ffffff;
    border-radius: 5px;
    transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;
}

.btn-primary:hover {
    background-color: #ff1493; /* Warna pink lebih gelap */
    transform: scale(1.05);
}

a {
    color: #ff69b4;
}

a:hover {
    text-decoration: none;
}
</style>
<body>
<div class='container'>
    <h2>Login</h2>
    <form action='login.php' method='post'>
        <div class='form-group'>
            <label for='username'>Username:</label>
            <input type='text' class='form-control' id='username' name='username' required>
        </div>
        <div class='form-group'>
            <label for='password'>Password:</label>
            <input type='password' class='form-control' id='password' name='password' required>
        </div>
        <button type='submit' class='btn btn-primary'>Login</button>
    </form>
    <p>Belum punya akun? <a href='register.php'>Daftar di sini</a>.</p>
</div>
</body>
</html>