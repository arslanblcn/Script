<?php
  session_start();
  include "restorant_header.php";
  require_once "../config.php";
  if (isset($_POST['submit'])) {
    $username = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    if (empty($username) || empty($password)) {
      echo '<script>Swal.fire("Hata", "Bütün alanların doldurulması gerekli", "error"); </script>';
    } else {
      try {
        $passwd = md5($password);
        // veritabanında kullanıcı bilgilerini çek ve kontrol et
        $query = "SELECT * FROM restorants WHERE email=:username and password=:password";
        $query = $conn->prepare($query);
        $query->execute(array(':username' => $username, ':password' => $passwd));
        if ($query->rowCount() > 0) {
          $row = $query->fetch();
          $_SESSION['username'] = $row['email'];
          $_SESSION['ad'] = $row['owner_firstname'];
          $_SESSION['soyad'] = $row['owner_lastname'];
          $_SESSION['restorant_id'] = $row['id'];
          header("Location: home.php");
        } else {
          echo '<script>Swal.fire("Hata", "Kullanıcı adı yada parola yanlış!", "error"); </script>';
        }
      } catch (PDOException $e) {
        echo "Error : " . $e->getMessage();
      }
    }
  }
  ?>
  <main>
    <div class="container mt-4">
      <div class="row mt-3 justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <form method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
                <div class="mb-3">
                  <label for="emailInputLabel" class="form-label">E-Posta</label>
                  <input type="text" name="email" class="form-control" id="emailInputLabel" />
                </div>
                <div class="mb-3">
                  <label for="passwordInputLabel" class="form-label">Şifre</label>
                  <input type="password" name="password" class="form-control" id="passwordInputLabel" />
                </div>
                <div class="mb-3 form-check">
                  <input type="checkbox" class="form-check-input" id="exampleCheck1" />
                  <label class="form-check-label" for="exampleCheck1">Beni Hatırla</label>
                </div>
                <button class="btn btn-success d-block" type="submit" name="submit">Üye Girişi</button>
              </form>
              <hr />
              Üyeliğin yok mu? <a href="register.php" class="link-danger">Yeni Üyelik</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <div class="fixed-bottom">
  <?php include "restorant_footer.php"; ?>
  </div>