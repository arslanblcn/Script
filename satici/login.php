<?php session_start(); ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Login Page</title>
  </head>
  <body>

  <?php 
    require_once "../config.php";
    if(isset($_POST['submit'])){
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        if(empty($email) || empty($password))  
        {  
            echo '<script>Swal.fire("Hata", "Bütün alanların doldurulması gerekli", "error"); </script>';
        } else {
            try{
                $passwd = md5($password);
                 // veritabanında kullanıcı bilgilerini çek ve kontrol et
                $query = "SELECT * FROM restorants WHERE email=:email and password=:password";
                $query = $conn->prepare($query);
                $query->execute(array(':email' => $email, ':password' => $passwd));
                if($query->rowCount() > 0) {
                    $row = $query->fetch();
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['id'] = $row['id'];
                    header("Refresh:1;url=home.php");
                } else {
                    echo '<script>Swal.fire("Hata", "Kullanıcı adı yada parola yanlış!", "error"); </script>';
                }
                
            } catch (PDOException $e) {
                echo "Error : ".$e->getMessage();
            }
        }
    }
  ?>
  <section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-12 col-lg-9 col-xl-7">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
          <div class="card-body p-4 p-md-5">
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Login Form</h3>
            <form method="POST" action="<?=$_SERVER['PHP_SELF'];?>">
              <div class="row">
                <div class="col-12 mb-4">
                  <div class="form-outline">
                    <input type="email" name="email" id="email" class="form-control form-control-lg" />
                    <label class="form-label" for="email">Email</label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <input type="password" name="password" id="password" class="form-control form-control-lg" >
                  <label class="form-label select-label" for="password">Password</label>
                </div>
              </div>
              <div class="mt-4 pt-2">
                <input class="btn btn-primary btn-lg" type="submit" name="submit" value="Submit" />
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
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