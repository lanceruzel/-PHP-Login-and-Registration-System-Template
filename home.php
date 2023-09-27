<?php 
session_start(); 
include 'config/database.php'; 
include 'includes/header.php'; 

$welcome_message = '';
$accountID = $_SESSION['accountID'];

        $query = "SELECT * FROM accounts WHERE accountID LIKE '$accountID'";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);

            $welcome_message = "Welcome {$row['first_name']}";
        }

        if(isset($_POST['logout'])){
            // Initialize the session
            //session_start();

            // Unset all of the session variables
            $_SESSION = array();
            
            // Destroy the session.
            session_destroy();

            header('Location: login.php');
        }
?>

<body>
    <div class="container">
        <h1><?php echo $welcome_message ?></h1>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
            <input type="submit" value="Logout" name="logout" class="btn btn-primary">
        </form>
    </div>
</body>
</html>