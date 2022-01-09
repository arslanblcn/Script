<?php
session_start();
require_once "config.php";
if (isset($_SESSION['username'])) { ?>
  <!doctype html>
  <html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Home Page</title>
  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
          <a class="navbar-brand" href="#">Hidden brand</a>
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
          </ul>
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
          <div class="dropdown mx-3">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo $_SESSION['username']; ?>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <?php
    if (isset($_POST['submit'])) {
      $restorant_id = htmlspecialchars(trim($_POST['restorant_id']));
      $query = $conn->prepare("SELECT * FROM restorant_menu WHERE restorant_id=:id");
      $query->bindParam(':id', $restorant_id);
      $query->execute();
    ?>
        <div class="container py-5 h-100">
          <div class="row justify-content-center h-100">
            <div class="col-8">
              <div class="card shadow-2-strong" style="border-radius: 15px;">
                <div class="card-body p-4 p-md-5">
                  <h3 class="">Sipariş Ver</h3>
                  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="basliklar-tab" data-bs-toggle="pill" data-bs-target="#basliklar" type="button" role="tab" aria-controls="basliklar-tab" aria-selected="false">Başlıklar</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="menu-tab" data-bs-toggle="pill" data-bs-target="#menu" type="button" role="tab" aria-controls="menu-tab" aria-selected="false">Menu</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="bilgiler-tab" data-bs-toggle="pill" data-bs-target="#bilgiler" type="button" role="tab" aria-controls="bilgiler-tab" aria-selected="false">Bilgiler</button>
                    </li>
                  </ul>
                  <div class="tab-content" id="pills-tabContent">
                  <?php 
                    if($query->rowCount() > 0){
                      $rows = $query->fetchAll();
                      
                  ?>
                    <div class="tab-pane fade show active" id="basliklar" role="tabpanel" aria-labelledby="basliklar-tab">
                      Başlıklar
                    </div>
                    <div class="tab-pane fade" id="menu" role="tabpanel" aria-labelledby="menu-tab">
                      Menu
                    </div>
                    <div class="tab-pane fade" id="bilgiler" role="tabpanel" aria-labelledby="bilgiler-tab">
                      Bilgiler
                    </div>
                    <?php }?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    <?php
    } else {
      header("Refresh: 1; url=home.php");
    }
    ?>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>

  </html>
<?php } else {
  header("Refresh: 2; url=login.php");
}
?>