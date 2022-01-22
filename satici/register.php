  <?php
    session_start();
    require_once "../config.php";
    include "restorant_header.php";
    $tur = "";
    $ilce = "";
    if (isset($_REQUEST['submit'])) {
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
        if ($password != $confirmPassword) {
            echo '<script>Swal.fire("Hata", "Parola Eşleşmiyor", "error"); </script>';
        } else {
            // Validate password strength
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);
            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
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
                $lastID = $conn->lastInsertId();
                if ($lastID) {
                    echo '<script>Swal.fire("Başarılı", "Kaydınız Başarı ile Gerçekleşmiştir", "success"); </script>';
                }
            }
        }
    }
    //echo "$firstName / $lastName / $email / $il / $ilce / $password / $confirmPassword";
    ?>
  <main>
      <div class="container mt-4">
          <div class="row mt-3">
              <div class="col-md-3 mt-3"></div>
              <div class="col-md-5">
                  <div class="row">
                      <div class="card-header">
                          <h3> Restorant Kaydı</h3>
                      </div>
                      <div class="card">
                          <div class="card-body">
                              <form method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
                                  <div class="row">
                                      <div class="col-md-6 mb-4">
                                          <div class="form-outline">
                                              <label class="form-label" for="restorant_adi">Restorant Adı</label>
                                              <input type="text" name="restorant_adi" id="restorant_adi" class="form-control" />
                                          </div>
                                      </div>
                                      <div class="col-md-6 mb-4">
                                          <div class="form-outline">
                                              <label class="form-label" for="telefon">Telefon Numarası</label>
                                              <input type="text" name="telefon" id="telefon" class="form-control" />
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-12 mb-4">
                                          <span class="text-bold">Satıcı Türü : </span>
                                          <div class="form-check form-check-inline">
                                              <label class="form-check-label" for="sahis">Şahıs</label>
                                              <input class="form-check-input" type="radio" name="tur" id="sahis" value="Şahıs">
                                          </div>
                                          <div class="form-check form-check-inline">
                                              <label class="form-check-label" for="ticari">Ticari</label>
                                              <input class="form-check-input" type="radio" name="tur" id="ticari" value="Ticari">
                                          </div>
                                      </div>
                                  </div>
                                  <h5>Restorant Adres ve İletişim Bilgileri</h5>
                                  <div class="row">
                                      <div class="col-6 mb-4">
                                          <label for="il" class="form-label">İl</label>
                                          <select name="il" id="il" class="form-control">
                                              <option value="">Seçin..</option>
                                          </select>
                                      </div>
                                      <div class="col-6 mb-4">
                                          <label for="ilce" class="form-label">İlçe</label>
                                          <select name="ilce" id="ilce" class="form-control" disabled="disabled">
                                              <option value="">Seçin..</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-12">
                                          <label class="form-label select-label" for="adres">Açık Adres</label>
                                          <input type="text" name="adres" id="adres" class="form-control">
                                      </div>
                                  </div>
                                  <h5 class="mt-3">Restorant Sorumlusu Bilgileri</h5>
                                  <div class="row">
                                      <div class="col-md-4 mb-4 pb-2">
                                          <div class="form-outline">
                                              <label class="form-label" for="ad">Adı</label>
                                              <input type="text" name="ad" id="ad" class="form-control" />
                                          </div>
                                      </div>
                                      <div class="col-md-4 mb-4 pb-2">
                                          <div class="form-outline">
                                              <label class="form-label" for="soyad">Soyadı</label>
                                              <input type="text" name="soyad" id="soyad" class="form-control" />
                                          </div>
                                      </div>
                                      <div class="col-md-4">
                                          <div class="form-outline">
                                              <label class="form-label" for="numara">Telefon</label>
                                              <input type="text" name="numara" id="numara" class="form-control" />
                                          </div>
                                      </div>
                                  </div>
                                  <h5 class="mt-3">Giriş Bilgisi</h5>
                                  <div class="row">
                                      <div class="col-md-12 mb-4 pb-2">
                                          <div class="form-outline">
                                              <label class="form-label" for="email">Email</label>
                                              <input type="email" name="email" id="email" class="form-control" />
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-6 mb-4 pb-2">
                                          <div class="form-outline">
                                              <label class="form-label" for="parola">Parola</label>
                                              <input type="password" name="parola" id="parola" class="form-control" />
                                          </div>
                                      </div>
                                      <div class="col-md-6 mb-4 pb-2">
                                          <div class="form-outline">
                                              <label class="form-label" for="parolaDogrula">Parola Dogrula</label>
                                              <input type="password" name="parolaDogrula" id="parolaDogrula" class="form-control" />
                                          </div>
                                      </div>
                                  </div>

                                  <div class="mt-4 pt-2">
                                      <input class="btn btn-success d-block" type="submit" name="submit" value="Kayıt Ol" />
                                  </div>

                              </form>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-1 position-relative">
                  <img src="../asset/main-page-adv-3.png" class="img-fluid" />
              </div>
          </div>
      </div>
  </main>
  <div class="fixed-bottom">
      <?php include "restorant_footer.php"; ?>
  </div>
  <script>
      $.getJSON("../il-bolge.json", function(sonuc) {
          $.each(sonuc, function(index, value) {
              var row = "";
              row += '<option value="' + value.il + '">' + value.il + '</option>';
              $("#il").append(row);
          })
      });
      $("#il").on("change", function() {
          var il = $(this).val();
          $("#ilce").attr("disabled", false).html("<option value=''>Seçin..</option>");
          $.getJSON("../il-ilce.json", function(sonuc) {
              $.each(sonuc, function(index, value) {
                  var row = "";
                  if (value.il == il) {
                      row += '<option value="' + value.ilce + '">' + value.ilce + '</option>';
                      $("#ilce").append(row);
                  }
              });
          });
      });
  </script>