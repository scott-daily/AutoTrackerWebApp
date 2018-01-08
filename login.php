<?php // Do not put any HTML above this line

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to index.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123

$failure = false;  // If we have no POST data

// Check to see if we have some POST data, if we do process it
session_start();
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
  unset($_SESSION['email']);
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION['error'] = "User name and password are required";
        header( 'Location: login.php' );
        return;
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header( 'Location: login.php' );
        return;
            }
    else {
        $check = hash('md5', $salt.$_POST['pass']);
        if ( $check == $stored_hash ) {
          $_SESSION["email"] = $_POST["email"];
          $_SESSION["success"] = "Logged in.";
          error_log("Login success ".$_POST['email']);
          header( 'Location: view.php' );
          return;
        } else {
            $_SESSION["error"] = "Incorrect password.";
            error_log("Login fail ".$_POST['email']." $check");
            header( 'Location: login.php') ;
            return;
        }
      }
  }


// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Scott Dailys's Login Page</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( isset($_SESSION["error"]) ) {
    echo('<p style="color: red;">'.$_SESSION["error"]."</p>\n");
    unset($_SESSION["error"]);
}
if (isset($_SESSION["success"]) ) {
  echo('<p style="color:green">'.$_SESSION["success"]."</p>\n");
  unset($_SESSION["success"]);
}
?>
<form method="POST">
  <p>Email:
  <input type="text" size="40" name="email"></p>
  <p>Password:
  <input type="text" size="40" name="pass"></p>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is the four character sound a cat
makes (all lower case) followed by 123. -->
</p>
</div>
</body>
