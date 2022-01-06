<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Hello, world!</title>
  </head>
  <body>
  <?php 
  require_once "config.php";
  $password = "";
  $firstName = "";
  $lastName = "";
  $email = "";
  $il = "";
  $ilce = "";
  $confirmPassword = "";
  if(isset($_REQUEST['submit'])){
    $firstName = htmlspecialchars($_REQUEST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $email = htmlspecialchars($_POST['email']);
    $il = htmlspecialchars($_POST['il']);
    $ilce = htmlspecialchars($_POST['ilce']);
    $password = htmlspecialchars($_POST['password']);
    $confirmPassword = htmlspecialchars($_POST['confirmPassword']);

    // Parola Kontrolu yap
    if($password != $confirmPassword){
      echo '<script>Swal.fire("Hata", "Parola Eşleşmiyor", "error"); </script>';
    } else{
      // Validate password strength
      $uppercase = preg_match('@[A-Z]@', $password);
      $lowercase = preg_match('@[a-z]@', $password);
      $number    = preg_match('@[0-9]@', $password);
      $specialChars = preg_match('@[^\w]@', $password);
      if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8){
        echo '<script>Swal.fire("Hata", "Parola büyük, küçük, numara ve özel karakter içermelidir", "error"); </script>';
      }
      // Eğer parolada sıkıntı yoksa veritabanına kaydet
      // username kısmı mail adresi
      else {
        $data = [
          'username' => $email,
          'password' => md5($password),
          'firstname' => $firstName,
          'lastname' => $lastName,
          'city' => $il,
          'district' => $ilce,
        ];
        $query = "INSERT INTO users (username, password, firstname, lastname, city, district) VALUES (:username, :password, :firstname, :lastname, :city, :district)";
        $stmt = $conn->prepare($query);
        $stmt->execute($data);
        if($stmt){
          echo '<script>Swal.fire("Başarılı", "Kaydınız Başarı ile Gerçekleşmiştir", "success"); </script>';
        }
      }
    }
  }
  //echo "$firstName / $lastName / $email / $il / $ilce / $password / $confirmPassword";
?>
  <section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-12 col-lg-9 col-xl-7">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
          <div class="card-body p-4 p-md-5">
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Registration Form</h3>
            <form method="POST" action="<?=$_SERVER['PHP_SELF'];?>">
              <div class="row">
                <div class="col-md-6 mb-4">
                  <div class="form-outline">
                    <input type="text" name="firstName" id="firstName" class="form-control form-control-lg" />
                    <label class="form-label" for="firstName">First Name</label>
                  </div>
                </div>
                <div class="col-md-6 mb-4">
                  <div class="form-outline">
                    <input type="text" name="lastName" id="lastName" class="form-control form-control-lg" />
                    <label class="form-label" for="lastName">Last Name</label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <input type="email" name="email" id="email" class="form-control form-control-lg" >
                  <label class="form-label select-label" for="email">Email</label>
                </div>
              </div>
              <div class="row">
                <div class="col-6 mb-4">
                  <label for="il" class="form-label">İl</label>
                  <select name="il" id="il" class="form-control form-control-lg">
                    <option value="">Seçin..</option>
                  </select>
                </div>
                <div class="col-6 mb-4">
                  <label for="ilce" class="form-label">İlçe</label>
                  <select name="ilce" id="ilce" class="form-control form-control-lg" disabled="disabled">
                    <option value="">Seçin..</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-4 pb-2">
                  <div class="form-outline">
                    <input type="password" name="password" id="password" class="form-control form-control-lg" />
                    <label class="form-label" for="password">Password</label>
                  </div>
                </div>
                <div class="col-md-6 mb-4 pb-2">
                  <div class="form-outline">
                    <input type="password" name="confirmPassword" id="passwordConfirm" class="form-control form-control-lg" />
                    <label class="form-label" for="passwordConfirm">Confirm Password</label>
                  </div>
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
    <script>
      $.getJSON("il-bolge.json", function(sonuc){
        $.each(sonuc, function(index, value){
            var row="";
            row +='<option value="'+value.il+'">'+value.il+'</option>';
            $("#il").append(row);
        })
      });
      $("#il").on("change", function(){
        var il=$(this).val();
        $("#ilce").attr("disabled", false).html("<option value=''>Seçin..</option>");
        $.getJSON("il-ilce.json", function(sonuc){
            $.each(sonuc, function(index, value){
                var row="";
                if(value.il==il)
                {
                    row +='<option value="'+value.ilce+'">'+value.ilce+'</option>';
                    $("#ilce").append(row);
                }
            });
        });
    });
    </script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>