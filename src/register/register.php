<?php 

include_once('../../db_connection/index.php');

$errors = array();

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';
    $email = $_POST['email'];

    if (empty($name)) {
        array_push($errors, "name is required");
    } elseif(!preg_match("/^[a-zA-ZëË ]*$/", $name)) {
        array_push($errors, "Only letters and white space allowed");
    }

    if (empty($email)) {
        array_push($errors, "Email is required");
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format");
    }

    if (empty($password)) {
        array_push($errors, "Password is required");
    }
    if($password != $confirmPassword) {
        array_push($errors, "Password nuk eshte i njejt");
    }

    $query = "SELECT * FROM users WHERE name=:name OR email=:email";
    $checkQuery = $conn->prepare($query);
    $checkQuery->bindParam(":name", $name);
    $checkQuery->bindParam(":email", $email);
    $checkQuery->execute();
    $result = $checkQuery->fetchAll();

    foreach ($result as $row) {
        if ($row['name'] == $name) {
            array_push($errors, "name already exists");
        }
        if ($row['email'] == $email) {
            array_push($errors, "Email already exists");
        }
    }

    if (count($errors) == 0) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        //delete $hashedPassword when we want to see the password and change  $sqlQuery->bindParam(":password", $hashedPassword); to   $sqlQuery->bindParam(":password", $password);

        $sql = "INSERT INTO users (name, password, email,confirmPassword) VALUES (:name, :password, :email, :confirmPassword)";
        $sqlQuery = $conn->prepare($sql);

        $sqlQuery->bindParam(":name", $name);
        $sqlQuery->bindParam(":password", $hashedPassword);
        $sqlQuery->bindParam(":email", $email);
        $sqlQuery->bindParam(":confirmPassword", $confirmPassword);

        $sqlQuery->execute();

        echo "<script>alert('Register succesfully!')</script>";
    }
}

?>