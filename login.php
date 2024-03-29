<?php
// Start a new session

// Check if the user is already logged in, if yes then redirect to the index page
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
  header('location: index.php');
  exit;
}

// Include the database connection
include('config/constants.php');

// Initialize variables with empty values
$username = '';
$password = '';
$username_err = '';
$password_err = '';
$login_err = '';

// Process form data when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Validate the form input
  if (empty(trim($_POST['username']))) {
    $username_err = 'Please enter a username.';
  } else {
    $username = trim($_POST['username']);
  }

  if (empty(trim($_POST['password']))) {
    $password_err = 'Please enter a password.';
  } else {
    $password = trim($_POST['password']);
  }

  // Validate the credentials
  if (empty($username_err) && empty($password_err)) {
    $sql = 'SELECT id, username, password FROM users WHERE username = ?';

    if ($stmt = mysqli_prepare($conn, $sql)) {
      // Bind the variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, 's', $param_username);

      // Set parameters
      $param_username = $username;

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        // Store the result
        mysqli_stmt_store_result($stmt);

        // Check if the username exists, if yes then verify the password
        if (mysqli_stmt_num_rows($stmt) == 1) {
          // Bind the result variables
          mysqli_stmt_bind_result($stmt, $id, $db_username, $hashed_password);

          if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($password, $hashed_password)) {
              // Password is correct, so start a new session
              session_start();

              // Store data in session variables
              $_SESSION['loggedin'] = true;
              $_SESSION['u_id'] = $id;
              $_SESSION['username'] = $db_username;

              // Redirect user to welcome page
              header('location: index.php');
            } else {
              // Password is not valid, display a generic error message
              $login_err = 'Invalid username or password.';
            }
          }
        } else {
          // Username doesn't exist, display a generic error message
          $login_err = 'Invalid username or password.';
        }
      } else {
        $login_err = 'Oops! Something went wrong. Please try again later.';
      }

      // Close the statement
      mysqli_stmt_close($stmt);
    }
  }

  // Close the connection
  mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <!-- Important to make website responsive -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant Website</title>

  <!-- Link our CSS file -->
  <link rel="stylesheet" href=
    "https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
            integrity=
    "sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
            crossorigin="anonymous"> 
            <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="http://localhost/food-order/" title="Logo">
                    <img src="images/logo.png" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>
<br>
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->
    <div class="wrapper">
    <div class="container my-4 ">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
    </div>
    <?php include('partials-front/footer.php'); ?>