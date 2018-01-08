<?php
require_once "pdo.php";

ini_set('display_errors', 1);
session_start();
if ( ! isset($_SESSION['email']) ) {
    die('Not logged in');
}

?>


<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Scott Daily's Auto Database</title>
</head>
<body>
<div class="container">
<h2>Tracking Autos for <?php echo $_SESSION['email'] ?> </h2>

<?php
if ( isset($_SESSION["success"]) ) {
    echo('<p style="color: green;">'.$_SESSION["success"]."</p>\n");
    unset($_SESSION["success"]);
}
?>

<h2>Automobiles</h2>
<table border="2">
  <caption style="caption-side:bottom"><a href="add.php">Add New</a> |
  <a href="logout.php">Logout</a></caption>
<?php
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
if($stmt->rowCount() == 0) {
  echo 'No records added';
}
else {
  while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
      echo "<tr><td>";
      $make = htmlspecialchars($row['make'], ENT_QUOTES);
      echo($make);
      echo("</td><td>");
      $year = htmlspecialchars($row['year'], ENT_QUOTES);
      echo($year);
      echo("</td><td>");
      $mileage = htmlspecialchars($row['mileage'], ENT_QUOTES);
      echo($mileage);
      echo("</td></tr>\n");
    }
  }
?>
</div>
</body>
</html>
