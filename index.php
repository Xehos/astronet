
<?php 
$MYSQLHOST = "localhost";
$MYSQLUSER = "root";
$MYSQLPASS = "root";
$MYSQLDB = "astronet";
$api_endpoint = "http://localhost:5050";
$stat = "";
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

if(isset($_GET["stat"])){
  $stat = htmlspecialchars(stripslashes($_GET["stat"]));    
}

$ARRAY_FIXEDFT_PAGES = array("domu","login");
?>

<!DOCTYPE html>
<html>
	<head>
  	<meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>AstroNet</title>
	    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
	    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="styles/main.css">
      <script type="text/javascript" src="js/menu_selected.js"></script>
      <style>
        .dropdown-item:hover{
          background-color:#0B0118;
        }
      </style>
  </head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-xl">
  <a class="navbar-brand" href="?page=domu"><span class="menuitem-text" id="logo"><img style="height: 1.3em;" src="img/svgs/logo.svg" class="mb-1"></span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Rozšířit panel">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item" id="menueldomu">
        <a class="nav-link" href="?page=domu"><span class="menuitem-text" id="menudomu">Domů</span><span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item" id="menuelobjekty">
        <a class="nav-link" href="?page=objekty"><span class="menuitem-text" id="menuobjekty">Astronomické objekty</span><span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item" id="menuelapi">
        <a class="nav-link" href="?page=API"><span class="menuitem-text" id="menuapi">API</span></a>
      </li>
      <li class="nav-item" id="menuelo_projektu">
        <a class="nav-link" href="?page=o_projektu"><span class="menuitem-text" id="menuo_projektu">O projektu</span></a>
      </li>
      <!--<li class="nav-item">
        <a class="nav-link disabled" href="#"><span class="text-muted">Disabled</span></a>
      </li>-->
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">

          <?php 

            if(!sessionCheck()){
              echo "<a class='nav-link' href='?page=login'><span class='menuitem-text' id='menulogin'>Přihlásit se</span></a>";
            }else{
              //echo "<a class='nav-link' href='?page=account'><span class='menuitem-text' id='menulogin'>".$_SESSION['user_details']["username"]."</span></a></li><li class='nav-item'>";
              //echo "<a class='nav-link' id='logout_link' href='?page=domu&action=logout'><span class='menuitem-text' id='menulogin'>"."Odhlásit se"."</span></a>";
              $username = $_SESSION['user_details']["username"];
              echo "<div class='dropleft show mr-1'>
              <a class='btn dropdown-toggle text-white' href='#' role='button' id='userDropdown' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                $username
              </a>

              <ul class='dropdown-menu' style='background-color:#30184E;!important;border:solid black 1px'  aria-labelledby='userDropdown'>
                <li><a class='dropdown-item text-white' href='?page=account'>Účet</a></li>";
                if(isset($_SESSION["user_details"])){
                  if($_SESSION["user_details"]["role"]==1){
                    echo "<li><a class='dropdown-item text-white' href='?page=administration'>Administrace</a></li>";
                  }
                }
                
                echo "<li><a class='dropdown-item text-white' href='?page=domu&action=logout'>Odhlásit</a></li>
              </ul>
            </div>";
            }
          ?>
      </li>


    </ul>
  </div>
</div>
</nav>

<?php 

  //GET querystring handler
if($_GET['page']=="domu"){
      echo "<div id='BG_VIGNETTE'>";
      echo "<div id='BG_SLIDESHOW'>";
    }
  echo "<div class='col pt-3'>";
  switch ($stat) {
    case 'edited':
      echo "<div class='alert alert-info' role='alert'>
      Záznam byl úspěšně upraven.
    </div>";
      break;

    case 'created':
      echo "<div class='alert alert-info' role='alert'>
      Záznam byl úspěšně přidán.
    </div>";
      break;

    case 'deleted':
      echo "<div class='alert alert-info' role='alert'>
      Záznam byl úspěšně smazán.
    </div>";

      break;

    case 'resetpass':
      echo "<div class='alert alert-info' role='alert'>
      Pro reset hesla se prosím znovu přihlašte heslem starým!
    </div>";

      break;
      
    case 'registeredsucc':
      echo "<div class='alert alert-success mb-2' role='alert'>Registrace byla úspěšná! Nyní se můžete přihlásit</div>";
      break;
    case 'passresetsuccess':
      echo "<div class='alert alert-success mb-2' role='alert'>Vaše heslo bylo úspěšně změněno!</div>";
      break;
    case 'accupdated':
      echo "<div class='alert alert-success mb-2' role='alert'>Údaje vašeho účtu byly úspěšně změněny!</div>";
      break;
    case 'wrongpassword':
      echo "<div class='alert alert-danger' role='alert'>
                Bylo zadáno špatné heslo!
            </div>";
      break;
    case 'usernotfound':
      echo "<div class='alert alert-danger' role='alert'>
                Uživatel se zadanou e-mailovou adresou nebyl nalezen!
            </div>";
      break;
    
    default:
      break;
  }
  echo "</col>";
  

  

  include("scripts/querystring_h.php");
  if($_GET['page']=="domu"){
  echo "</div>";
  echo "</div>";
  }
 ?>
</body>

  <footer class="text-center justify-content-center color-primary-4 
  <?php if(in_array($_GET['page'], $ARRAY_FIXEDFT_PAGES)){echo "fixed-ft";}else{echo "rel-ft";} ?>">
   <?php $rok=date("Y"); echo "Adam Huml &copy$rok"; ?> 
  Využívá <a href="https://getbootstrap.com" class="color-primary-4">Bootstrap 4.6.2

<footer>

</html>