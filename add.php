<?php
require_once "pdo.php";

ini_set('display_errors', 1);
session_start();
if ( ! isset($_SESSION['email']) ) {
    die('Not logged in');
}

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to index.php
    header("Location: view.php");
    return;
}



if ( isset($_POST['add']) ) {
    if (!(is_numeric($_POST['year'])&&is_numeric($_POST['mileage']))){
        $_SESSION['error'] = "Mileage and year must be numeric";
        header( 'Location: add.php' );
        return;
    }elseif(strlen($_POST['make'])<1){
            $_SESSION['error']= "Make is required";
            header( 'Location: add.php' );
            return;
    }
    else{
        $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)');
        $stmt->execute(array(
            ':mk' => $_POST['make'],
            ':yr' => $_POST['year'],
            ':mi' => $_POST['mileage']));
        $_SESSION['success'] = "Record inserted";
        header( 'Location: view.php' );
        return;
    }
}

?>


<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Scott Daily's Auto Database</title>
</head>
<h2>Tracking Autos for <?php echo $_SESSION['email'] ?> </h2>

<?php
if ( isset($_SESSION["error"]) ) {
    echo('<p style="color: red;">'.$_SESSION["error"]."</p>\n");
    unset($_SESSION["error"]);
}

?>


<form method="post">
<p>Make:
<input type="text" name="make" size="40"></p>
<p>Year:
<input type="text" name="year"></p>
<p>Mileage:
<input type="text" name="mileage"></p>
<p>
<input type="submit" name = "add" value="Add"/>
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
