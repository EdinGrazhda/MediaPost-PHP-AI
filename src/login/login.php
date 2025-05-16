<?php
    include('../../db_connection/index.php');
  
    session_start();

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];        // Retrieve user data by name only
        $stmt = $conn->prepare("SELECT * FROM users WHERE name = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        
        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            // Password matches
            $_SESSION['name'] = $name;
            header("Location: ../../public/panel.php");
            exit();
        } else {
            echo "Username ose password i gabuar.";
        }
    }

?>