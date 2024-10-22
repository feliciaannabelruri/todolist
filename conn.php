<?php
    $servername = "localhost";   // Typically "localhost", adjust if using a remote DB
    $username = "u571101154_todowish";  // Your database username
    $password = "Todowish123";  // Your database password
    $dbname = "u571101154_todowish";  // Your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
