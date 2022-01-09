  <?php
  session_start();
  include "header.php";
  require_once "config.php";
  if (isset($_POST['submit'])) {
    $username = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    if (empty($username) || empty($password)) {
      echo '<script>Swal.fire("Hata", "Bütün alanların doldurulması gerekli", "error"); </script>';
    } else {
      try {
        $passwd = md5($password);
        // veritabanında kullanıcı bilgilerini çek ve kontrol et
        $query = "SELECT * FROM users WHERE username=:username and password=:password";
        $query = $conn->prepare($query);
        $query->execute(array(':username' => $username, ':password' => $passwd));
        if ($query->rowCount() > 0) {
          $row = $query->fetch();
          $_SESSION['username'] = $row['username'];
          $_SESSION['ad'] = $row['firstname'];
          $_SESSION['soyad'] = $row['lastname'];
          $_SESSION['id'] = $row['id'];
          header("Location: user.php");
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
      <div class="row mt-3">
        <div class="col-md-3">
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

          <div class="card mt-3">
            <div class="card-header card__header text-white">
              Yemek Sepetim
            </div>
            <div class="card-body d-flex align-items-center">
              <i class="fas fa-shopping-basket"></i>
              <p class="card-text mx-3">Sepetiniz henüz boş.</p>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <h3>Kredi kartınız bizi hiç ilgilendirmiyor!</h3>

          <p>
            Siparişlerinizi en doğru, en hızlı ve en kolay şekilde alıyor,
            ilgili restorana eksiksiz ve anında iletiyoruz. Kredi kartı,
            güvenlik sorunu yok. Siparişinizi
            <b>hiçbir ekstra ücret ödemeden</b>
            verin, <b>10-45 dakika</b> (restoranın ortalama gönderim süresi)
            içerisinde yemeğiniz elinizde olsun.
          </p>
          <img src="./asset/yemeksepeti.png" alt="" class="img-fluid" />

          <div class="row mt-2">
            <div class="col-md-8">
              <img src="./asset/main-page-adv.png" alt="" class="img-fluid adv-image" />

              <div id="carouselExampleControls" class="carousel slide mt-2" data-bs-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="./asset/slider-1.webp" class="d-block w-100" alt="..." />
                  </div>
                  <div class="carousel-item">
                    <img src="./asset/slider-2.webp" class="d-block w-100" alt="..." />
                  </div>
                  <div class="carousel-item">
                    <img src="./asset/slider-3.webp" class="d-block w-100" alt="..." />
                  </div>
                  <div class="carousel-item">
                    <img src="./asset/slider-4.jpg" class="d-block w-100" alt="..." />
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>

              <img src="./asset/main-page-adv-2.png" alt="" class="img-fluid adv-image mt-2" />
            </div>

            <div class="col-md-4">
              <div class="card card--pink">
                <h6 class="card-header card__header text-white text-center">
                  Fırsatlar
                </h6>
                <div class="card-body">
                  <ul class="list">
                    <li class="list__item">
                      <h6 class="list__title">
                        Popeyes, Çankaya (Mustafa Kemal Mah.)
                      </h6>
                      <p>
                        Sadece Yemeksepeti'nde, 'Müthiş Fırsat Kovası' 70,57
                        TL yerine 39,99 TL!
                      </p>
                    </li>
                    <li class="list__item">
                      <h6 class="list__title">Dominos Pizza (Emek Mah.)</h6>
                      <p>
                        Sadece Yemeksepeti'nde, Ikili orta boy pizza 70,57 TL
                        yerine 39,99 TL!
                      </p>
                    </li>
                    <li class="list__item">
                      <h6 class="list__title">
                        Meşhur Adıyaman Çiğ Köftecisi Bayram Usta, Keçiören
                        (Esertepe Mah.)
                      </h6>
                      <p>
                        Sadece Yemeksepeti'nde, 2 kilo cig kofte 70,57 TL
                        yerine 39,99 TL!
                      </p>
                    </li>
                    <li class="list__item">
                      <h6 class="list__title">
                        Kokomet Köfte & Kokoreç & Tavuk, Etimesgut (Altay Mah.
                        - Eryaman)
                      </h6>
                      <p>
                        Sadece Yemeksepeti'nde, Iki adet kokorec 70,57 TL
                        yerine 39,99 TL!
                      </p>
                    </li>
                    <li class="list__item">
                      <h6 class="list__title">
                        Popeyes, Etimesgut (Etiler Mah.)
                      </h6>
                      <p>
                        Sadece Yemeksepeti'nde, 'Müthiş Fırsat Kovası' 70,57
                        TL yerine 39,99 TL!
                      </p>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="card card--yellow mt-3">
                <h6 class="card-header card__header--yellow text-white text-center">
                  Yeni Eklenen Restoranlar
                </h6>
                <div class="card-body">
                  <ul class="list">
                    <li class="list__item">
                      <p>
                        Meşhur Adıyaman Çiğ Köftecisi Bayram Usta, Keçiören
                        (Esertepe Mah.)
                      </p>
                    </li>
                    <li class="list__item">
                      <p>
                        Kokomet Köfte & Kokoreç & Tavuk, Etimesgut (Altay Mah.
                        - Eryaman)
                      </p>
                    </li>
                    <li class="list__item">
                      <p>
                        Ziyafet Çiğ Köfte, Pursaklar (Saray Cumhuriyet Mah.)
                        Borsa Ocakbaşı
                      </p>
                    </li>
                    <li class="list__item">
                      <p>
                        Yenimahalle (Batıkent Kardelen Mah.) Feriştah El
                        Yapımı Gerçek Çiğ
                      </p>
                    </li>
                    <li class="list__item">
                      <p>Köfte, Altındağ (Aydınlıkevler Mah.)</p>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-1 position-relative">
          <img src="./asset/main-page-adv-3.png" class="img-fluid" />
        </div>
      </div>
    </div>
  </main>
  <?php include "footer.php"; ?>