<?php include 'config/database.php'; ?>
<?php include 'includes/header.php'; ?>

<?php 
    $first_name = $last_name = $email = $password = $repassword = $birthdate = '';
    $repasswordError = $emailError = '';
    $viewModal = false;

    //Form submit
    if(isset($_POST['login'])){
        $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
        //Check Email Validity
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $query = "SELECT * FROM accounts WHERE email LIKE '$email'";
        $result = mysqli_query($conn, $query);
        
        if(mysqli_num_rows($result) > 0){
            $emailError = 'Email already exists.';
        }
        //End
        
        //Validate repassword
        if($_POST['repassword'] == $_POST['password']){
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); //hash the password
        }else{
            $repasswordError = 'Password does not match';
        }

        //Insert new Account
        if(empty($emailError) && empty($repasswordError)){
            $query = "INSERT INTO accounts (first_name, last_name, email, password) VALUES('$first_name', '$last_name', '$email', '$password')";

            if(mysqli_query($conn, $query)){
                //Success
                //header('Location: login.php');
                $viewModal = true;
                echo "<script type='text/javascript'>
                        $(document).ready(function(){
                        $('#modal').modal('show');
                        });
                        </script>";
            }else{
                //Error
                echo 'Error: ' . mysqli_error($conn);
            }
        }
    }

    //
    if(isset($_POST['successLoginNow'])){
        header('Location: login.php');
    }
?>

<body>
    <div class="container">
        <!-- Modal -->
        <div class="modal fade" id="modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true" style>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modal-content-center">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Information</h1>
                    </div>
                    <div class="modal-body">
                        Account Successfully created.
                    </div>
                    <div class="modal-footer">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                            <button type="submit" name="successLoginNow" class="btn btn-primary">Login now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal-End -->

        <div class="row">
            <div class="col d-flex justify-content-center align-items-center vh-100">
                <form class="p-5 shadow rounded-3 form-anticlear" style="width: 500px;" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                    <p class="fs-2 fw-bolder">Register</p>

                    <div class="row g-1 mb-3">
                        <div class="col-sm-6">
                            <label for="f_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                            
                            <div class="invalid-feedback">
                                <?php echo $first_nameError; ?>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="l_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                    </div>

                    <div class="row g-1 mb-3">
                        <div class="col-sm-6">
                            <label for="birthdate" class="form-label">Birthdate</label>
                            <input type="date" class="form-control" id="birthdate">
                        </div>

                        <div class="col-sm-6">
                            <label for="gender">Sex</label>
                            <select class="form-select mt-1" aria-label="Default select example" id="gender">
                                <option selected value="1">Male</option>
                                <option value="2">Female</option>
                                <option value="3">Secret</option>
                            </select>
                        </div>
                        
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control <?php echo $emailError ? 'is-invalid' : null ?>" id="email" name="email" aria-describedby="emailHelp" required>
                        <div class="invalid-feedback">
                            <?php echo $emailError; ?>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>

                        <label for="repassword" class="form-label mt-2">Re-Enter Password</label>
                        <input type="password" class="form-control <?php echo $repasswordError ? 'is-invalid' : null ?>" id="repassword" name="repassword" required>
                        <div class="invalid-feedback">
                            <?php echo $repasswordError; ?>
                        </div>
                    </div>
                    
                    <div class="d-flex flex-column justify-content-center align-items-center row-gap-2 mt-4">     
                        <button type="submit" name="login" value="Register" class="btn btn-primary float-end w-75 py-2 my-2">Register</button>

                        <div class="d-flex flex-row justify-content-center align-items-center w-100 my-2">
                            <hr class="w-100"> <span class="mx-4">or</span>
                            <hr class="w-100">
                        </div>
                    
                        <a href="login.php" class="link-primary">Login Instead</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>