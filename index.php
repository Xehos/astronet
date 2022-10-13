
<?php 
$MYSQLHOST = "localhost";
$MYSQLUSER = "root";
$MYSQLPASS = "root";
$MYSQLDB = "astronet";

$conn = mysqli_connect($MYSQLHOST,$MYSQLUSER,$MYSQLPASS,$MYSQLDB);
if (mysqli_connect_errno()) {
  echo "Chyba připojení k databázi: " . mysqli_connect_error();
  exit();
}
require_once("scripts/Db.php");
Db::connect($MYSQLHOST,$MYSQLDB,$MYSQLUSER,$MYSQLPASS);

include("scripts/sessioncheck.php");
ob_start();
session_start();


if(isset($_GET["action"]) && $_GET["action"]=="logout"){
  include("scripts/logout.php");
}

?>

<!DOCTYPE html>
<html>
	<head>
  	<meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>AstroNet</title>
	    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="styles/main.css">
      <script type="text/javascript" src="js/menu_selected.js"></script>
  </head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-xl">
  <a class="navbar-brand" href="?page=domu"><span class="menuitem-text" id="logo">AstroNet</span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Rozšířit panel">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item" id="menueldomu">
        <a class="nav-link" href="?page=domu"><span class="menuitem-text" id="menudomu">Domů</span><span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item" id="menuelfunkce">
        <a class="nav-link" href="?page=funkce"><span class="menuitem-text" id="menufunkce">Funkce</span></a>
      </li>
      <li class="nav-item" id="menuelo_projektu">
        <a class="nav-link" href="?page=o_projektu"><span class="menuitem-text" id="menuo_projektu">O projektu</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#"><span class="text-muted">Disabled</span></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
          <?php 
            if(!sessionCheck()){
              echo "<a class='nav-link' href='?page=login'><span class='menuitem-text' id='menulogin'>Přihlásit se</span></a>";
            }else{
              echo "<a class='nav-link' href='?page=account'><span class='menuitem-text' id='menulogin'>".$_SESSION['user_details']["username"]."</span></a></li><li class='nav-item'>";
              echo "<a class='nav-link' id='logout_link' href='?page=domu&action=logout'><span class='menuitem-text' id='menulogin'>"."Odhlásit se"."</span></a>";
            }
          ?>
      </li>


    </ul>
  </div>
</div>
</nav>

<?php 
  //GET querystring handler

  include("scripts/querystring_h.php");


 ?>
</body>
<footer>
</footer>
</html>