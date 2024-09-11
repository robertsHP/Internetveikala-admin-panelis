
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($username == $correct_username && $password == $correct_password) {
            $row = Database::getRowFrom(
                'users', 
                'email', 
                $payload['email'], 
                PDO::PARAM_STR);
        
            if(empty($row)) {
                header('Location: /veikals/admin/index.php');
                exit();
            }
    
            $_SESSION["id"] = $row['user_id'];
            $_SESSION["name"] = $row['name'];
            $_SESSION["surname"] = $row['surname'];
            $_SESSION["email"] = $row['email'];
        
            header('Location: /veikals/admin/src/panel.php');
            exit();
        } else {
            header('Location: /veikals/admin/index.php');
            exit();
        }
    }
?>