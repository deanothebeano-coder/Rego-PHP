<?php
 
        session_start();
        session_unset();
 
        //CONNECT TO DB
        include_once("database.php");
 
        $errorMessage = "";
        $successMessage = "";

        //USER CLICKS REGISTER
        if(isset($_REQUEST['register'])){
 
 
        //CLEAN-UP USER INPUT
        $firstName = strip_tags($_REQUEST['firstName']);
        $surname = strip_tags($_REQUEST['surname']);
        $email = strip_tags($_REQUEST['email']);
        $password = strip_tags($_REQUEST['password']);
        $confirm_password = strip_tags($_REQUEST['confirm_password']);
        $staff = $_REQUEST['staff'];
 
        $firstName = stripslashes($firstName);
        $surname = stripslashes($surname);
        $email = stripslashes($email);
        $password = stripslashes($password);
        $confirm_password = stripslashes($confirm_password);
 
        $firstName = mysqli_real_escape_string($connection, $firstName);
        $surname = mysqli_real_escape_string($connection, $surname);
        $email = mysqli_real_escape_string($connection, $email);
        $password = mysqli_real_escape_string($connection, $password);
        $confirm_password = mysqli_real_escape_string($connection, $confirm_password);
 
        
     
        
        $SQL_select = "SELECT Email FROM user WHERE Email = '$email'";
 
        //CHECK IF ACCOUNT ALREADY EXISTS
        if(mysqli_num_rows(mysqli_query($connection, $SQL_select))) {
            $errorMessage = "Account already exists";
        }
        //Check if passwords match
        elseif($password != $confirm_password) {
            $errorMessage = "Passwords do not match" ;
        }
        //Check all required fields
        elseif (empty($firstName) || empty($surname) || empty($email) || empty($password) || empty($confirm_password)) {
            $errorMessage = "Please complete all fields.";
        }
        //Check valid email format
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Please enter valid email address";
        }
        // Insert the new user
        else {
            $password = sha1($password);
            
            $SQL_insert = "INSERT INTO user(FirstName, Surname, Email, Password, Staff) VALUES('$firstName', '$surname', '$email', '$password', $staff)";
 
            mysqli_query($connection, $SQL_insert);
            $user_id = mysqli_insert_id($connection);

            // Check if the insert was successful
            if($user_id <= 0)
            {
                $errorMessage = "Unable to create account. Please try again.";
            }
            else
            {
                $successMessage = "Account created!";
                header("refresh: 2; url=login.php");
            }
            
        }
    }
     
    mysqli_close($connection)
 
?>
<html>
    <head>  
        <title>Register - The Northwind Shop</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/css/styles.css" />
    </head>
 
    <body>
    <div class="container">
        <div class="header">
        </div>

        <div class="navbar">
        </div>

        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-8>
                <div class="content">
                    <p class="text-danger"><?php echo $errorMessage;?></p>
                    <p class="text-success"><?php echo $successMessage;?></p>
                    <h3 class="mb-4">Enter registration details below.</h3>
                    <form action="" method="post">
                        <div class="row mb-3">
                            <div class="col-4">First Name:</div>
                            <div class="col-4"><input type="text" class="form-control" name="firstName" placeholder="Enter first name"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">Surname:</div>
                            <div class="col-4"><input type="text" class="form-control" name="surname" placeholder="Enter surname"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">Email:</div>
                            <div class="col-8"><input type="text" class="form-control" name="email" placeholder="Enter email"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">Password:</div>
                            <div class="col-4"><input type="password" class="form-control" name="password" placeholder="Enter password"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">Confirm password:</div>
                            <div class="col-4"><input type="password" class="form-control" name="confirm_password" placeholder="Re-Enter password"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">Account type:</div>
                            <div class="col-4"><select name="staff" class="form-select">
                                <option value="0">Student</option>
                                <option value="1">Staff</option>
                            </select></div>
                        </div>
                        <div class="row"><div class="col"><input type="submit" name="register" value="Register" class="btn btn-primary"></div></div>
                    </form>
                    <p class="small">Already have an account? <a href="login.php">Login here </a></p>
                </div>
            </div>
        </div>        
 
        <div class="footer">
        </div>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    
    </body>
</html>