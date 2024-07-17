<?php
    //START/CONTINUE SESSION AND CLEAN IT
    session_start();
    session_unset();
    

    //CONNECT TO DB
    include_once("database.php");

    $errorMessage = "";

    //USER CLICKS LOGIN
    if(isset($_REQUEST['login'])){

        if(!empty($_REQUEST['email']) && !empty($_REQUEST['password'])) {

                
            //CLEAN-UP USER INPUT
            $email = stripslashes(strip_tags($_REQUEST['email']));
            $password = stripslashes(strip_tags($_REQUEST['password']));

            // $email = stripslashes($email);
            // $password = stripslashes($password);

            $email = mysqli_real_escape_string($connection, $email);
            $password = mysqli_real_escape_string($connection, $password);

            $SQL_select = "SELECT * FROM user WHERE Email = '$email' LIMIT 1";

            //PLACE SQL RESULTS IN OBJECT
            $result = mysqli_query($connection, $SQL_select);

            if ($result->num_rows > 0) 
            {
                //PLACE RESULTS IN ARRAY
                $row = mysqli_fetch_array($result);

                $dbPassword = $row['Password'];

                //LOGIN CREDENTIALS CORRECT
                if(sha1($password) == $dbPassword){

                    $_SESSION['UserID'] = $row['UserID'];
                    $_SESSION['Email'] = $row['Email'];
                    $_SESSION['Staff'] = $row['Staff'];

                    header("refresh: 2; url=index.php");

                }
                else
                {
                    $errorMessage = "Incorrect email and/or password.";
                }
            }
            else  
            {
                $errorMessage = "Incorrect email and/or password.";
            }
        }

        else
        {
            $errorMessage = "Please enter email and/or password";
        }
    }

    mysqli_close($connection)

?>
<html>
    <head>  
        <title>Login - The Northwind Shop</title>
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
                <div class="col-6">
                    <div class="content">
                        <p class="text-danger"><?php echo $errorMessage;?></p>
                        <h3 class="mb-4">Enter login details below.</h3>
                        <form action="" method="post">    
                            <div class="row mb-3">            
                                <div class="col-4">Email:</div>
                                <div class="col-8"><input type="text" class="form-control" name="email" placeholder="Enter email"></div>
                            </div>  
                            <div class="row mb-3">  
                                <div class="col-4">Password:</div>
                                <div class="col-8"><input type="password"  class="form-control" name="password" placeholder="Enter password"></div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col">
                                    <input type="submit" name="login" value="Login" class="btn btn-primary">
                                </div>
                            </div>
                        </from>            
                    </div>
                    <p class="small">Forgot password? <a href="forgot.php">Click here </a></p>
                    <p class="small">New user? <a href="register.php">Register here </a></p>
                </div>
            </div>

            <div class="footer">
            </div>
        </div>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    </body>
</html>