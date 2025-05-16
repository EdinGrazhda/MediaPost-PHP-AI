<?php
    include('../db_connection/index.php');
    session_start();

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Këtu mund të bëni verifikimin e përdoruesit në bazën e të dhënave
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['username'] = $username;
            header("Location: ../index.php");
            exit();
        } else {
            echo "Username ose password i gabuar.";
        }
    }

?>