<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Restorant Kayıt</title>
  </head>
  <body>
  <?php 
        require_once "../config.php";

        if(isset($_REQUEST['submit'])) {
        $restorant_name = htmlspecialchars(trim($_REQUEST['restorant_adi']));
        $email = htmlspecialchars(trim($_REQUEST['email']));
        $password = htmlspecialchars(trim($_REQUEST['parola']));
        $confirmPassword = htmlspecialchars(trim($_REQUEST['parolaDogrula']));
        $phone_number = htmlspecialchars(trim($_POST['telefon']));
        $restorant_type = htmlspecialchars(trim($_POST['tur']));
        $city = htmlspecialchars(trim($_POST['il']));
        $district = htmlspecialchars(trim($_POST['ilce']));
        $current_address = htmlspecialchars(trim($_POST['adres']));
        $owner_firstname = htmlspecialchars(trim($_POST['ad']));
        $owner_lastname = htmlspecialchars(trim($_POST['soyad']));
        $owner_phone = htmlspecialchars(trim($_POST['numara']));

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
                    'restorant_name' => $restorant_name,
                    'email' => $email,
                    'password' => md5($password),
                    'phone_number' => $phone_number,
                    'restorant_type' => $restorant_type,
                    'city' => $city,
                    'district' => $district,
                    'current_address' => $current_address,
                    'owner_firstname' => $owner_firstname,
                    'owner_lastname' => $owner_lastname,
                    'owner_phone' => $owner_phone,
                ];
                $query = "INSERT INTO restorants (restorant_name, email, password, phone_number, restorant_type, 
                city, district, current_address, owner_firstname, owner_lastname, owner_phone) 
                VALUES (:restorant_name, :email, :password, :phone_number, :restorant_type, 
                :city, :district, :current_address, :owner_firstname, :owner_lastname, :owner_phone)";
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
                            <input type="text" name="restorant_adi" id="restorant_adi" class="form-control form-control-lg" />
                            <label class="form-label" for="restorant_adi">Restorant Adı</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="form-outline">
                            <input type="text" name="telefon" id="telefon" class="form-control form-control-lg" />
                            <label class="form-label" for="telefon">Telefon Numarası</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <span class="text-bold">Satıcı Türü : </span>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tur" id="sahis" value="Şahıs">
                            <label class="form-check-label" for="sahis">Şahıs</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tur" id="ticari" value="Ticari">
                            <label class="form-check-label" for="ticari">Ticari</label>
                        </div>
                    </div>
                </div>
                <h5>Restorant Adres ve İletişim Bilgileri</h5>
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
                    <div class="col-12">
                        <input type="text" name="adres" id="adres" class="form-control form-control-lg" >
                        <label class="form-label select-label" for="adres">Açık Adres</label>
                    </div>
                </div>
                <h5 class="mt-3">Restorant Sorumlusu Bilgileri</h5>
                <div class="row">
                    <div class="col-md-4 mb-4 pb-2">
                        <div class="form-outline">
                            <input type="text" name="ad" id="ad" class="form-control form-control-lg" />
                            <label class="form-label" for="ad">Adı</label>
                        </div>
                    </div>
                        <div class="col-md-4 mb-4 pb-2">
                        <div class="form-outline">
                            <input type="text" name="soyad" id="soyad" class="form-control form-control-lg" />
                            <label class="form-label" for="soyad">Soyadı</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-outline">
                            <input type="text" name="numara" id="numara" class="form-control form-control-lg" />
                            <label class="form-label" for="numara">Telefon</label>
                        </div>
                    </div>
                </div>
                <h5 class="mt-3">Giriş Bilgisi</h5>
                <div class="row">
                    <div class="col-md-12 mb-4 pb-2">
                        <div class="form-outline">
                            <input type="email" name="email" id="email" class="form-control form-control-lg" />
                            <label class="form-label" for="email">Email</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4 pb-2">
                    <div class="form-outline">
                        <input type="password" name="parola" id="parola" class="form-control form-control-lg" />
                        <label class="form-label" for="parola">Parola</label>
                    </div>
                    </div>
                    <div class="col-md-6 mb-4 pb-2">
                    <div class="form-outline">
                        <input type="password" name="parolaDogrula" id="parolaDogrula" class="form-control form-control-lg" />
                        <label class="form-label" for="parolaDogrula">Parola Dogrula</label>
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
      $.getJSON("../il-bolge.json", function(sonuc){
        $.each(sonuc, function(index, value){
            var row="";
            row +='<option value="'+value.il+'">'+value.il+'</option>';
            $("#il").append(row);
        })
      });
      $("#il").on("change", function(){
        var il=$(this).val();
        $("#ilce").attr("disabled", false).html("<option value=''>Seçin..</option>");
        $.getJSON("../il-ilce.json", function(sonuc){
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