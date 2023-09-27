<?php include 'config/database.php'; ?>
<?php include 'includes/header.php'; ?>

<?php 
    session_start();

    $email = $password = '';
    $alert = '';

    if(isset($_POST['submit'])){
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        
        $query = "SELECT * FROM accounts WHERE email LIKE '$email'";
        $result = mysqli_query($conn, $query);
        
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            
            if(password_verify($password, $row['password'])){
                $_SESSION['accountID'] = $row['accountID'];
                $_SESSION['isLogin'] = true;

                //Success login
                header('Location: home.php');
                
            }else{
                $alert = '<div class="alert alert-danger" role="alert">
                        Password does not match.
                    </div>';
            }
            
        }else{
            $alert = '<div class="alert alert-danger" role="alert">
                        Account not found.
                    </div>';
        }

        mysqli_close($conn);
    }
?>

<body>
    <div class="container">
        <div class="row">
            <div class="col d-flex justify-content-center align-items-center vh-100">
                <form class="p-5 shadow rounded-3" style="width: 400px;" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                    <p class="fs-2 fw-bolder">Login </p>

                    <div class="w-100">
                        <?php echo $alert ?>
                    </div>

                    <div class="mb-3">
                        <label for="emailInput">Email Address</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="passwordInput">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="d-flex flex-column justify-content-center align-items-center row-gap-2 mt-4">
                        <input type="submit" name="submit" value="Login" class="btn btn-primary float-end w-75 py-2 my-3">
                        
                        <div class="d-flex flex-row justify-content-center align-items-center w-100 py">
                            <hr class="w-100"> <span class="mx-4">or</span> <hr class="w-100">
                        </div>
                        
                        <a href="register.php" class="text-center link-primary w-75 py-2 my-3">
                            Create new Account
                        </a>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>