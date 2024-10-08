<?php
require_once __DIR__ . '/../config.php';
spl_autoload_register(function($class){ require_once  ROOT_PATH . '/' . $class . '.php';});
use App\Lib\Auth;

$search = '';
if(!empty($_GET['search'])){
    $search = $_GET['search'];
}
$statut = '';
if(isset($_GET['statut'])){
  $statut = $_GET['statut'];
}
?>

<header>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php?slug=views/home.php">EAFC</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">

      <ul class="navbar-nav align-items-center">
        <?php if(Auth::verify()){ if(Auth::admin()){ ?>
        <li class="nav-item">
          <a class="nav-link <?= (str_contains($_SERVER['REQUEST_URI'], 'iews/all.php') && $statut == '')?'active':'' ?>" aria-current="page" href="index.php?slug=views/all.php">All</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($statut == 1)?'active':'' ?>" href="index.php?slug=views/all.php&statut=1">Formations actives</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($statut == '0')?'active':'' ?>" href="index.php?slug=views/all.php&statut=0">Formations suspendues</a>
        </li>
        <li class="nav-item">
          <a class="nav-link  <?= (str_contains($_SERVER['REQUEST_URI'], 'views/ajoutFormation.php') && $statut == '')?'active':'' ?>" href="index.php?slug=views/ajoutFormation.php">Ajouter une formation</a>
        </li>
        <?php } ?>
          <li class="nav-item">
            <form class="d-flex" role="search" action="index.php?slug=App/Controller/Deconnexion.php" method="post">
              <button class="btn btn-outline-success" type="Deconnexion">Deconnexion</button>
            </form>
          </li>
        <?php }else{ ?>
          <li class="nav-item">
            <a class="nav-link" href="index.php?slug=views/login.php">Connexion</a>
          </li>
        <?php } ?>



        

      </ul>
    </div>
    <?php if(Auth::admin()){  ?>
    <div class="container-fluid">
    <form class="d-flex" role="search" action="index.php" method="get">
      <input type="hidden" name="slug" value="views/all.php">
      <?php if(isset($_GET['statut'])){ ?>
        <input type="hidden" name="statut" value="<?= $_GET['statut'] ?>">
      <?php } ?>
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search" value="<?= $search ?>">

      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  </div>
  <?php }  ?>


  </div>
</nav>
</header>