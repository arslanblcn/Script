<?php
  session_start();
  require_once "config.php";
  include "header.php"; 
  if (isset($_SESSION['username'])) { 
?>
<main>
  <div class="container mt-4">
    <div class="row mt-3">
      <div class="col-md-3 mt-3">
        <div class="accordion accordion-flush" id="accordionFlushExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                <div class="d-flex align-items-center">
                  <div class="user-avatar">
                    <i class="far fa-user p-3"></i>
                  </div>
                  <div class="mx-3">
                    <h6 class="color-main"><?php echo $_SESSION['ad'] . " " . $_SESSION['soyad']; ?></h6>
                    <span>17,622 Toplam Puan</span>
                  </div>
                </div>
              </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">
                <ul>
                  <li class="mb-2">
                    <a href="">Bildirimlerim</a>
                  </li>
                  <li class="mb-2">
                    <a href="">Profilim</a>
                  </li>
                  <li class="mb-2">
                    <a href="">Siparişlerim</a>
                  </li>
                  <li class="mb-2">
                    <a href="">Favorilerim</a>
                  </li>
                  <li class="mb-2">
                    <a href="">Adreslerim</a>
                  </li>
                  <li class="mb-2">
                    <a href="">Bilgilerim</a>
                  </li>
                  <li class="mb-2">
                    <div class="d-grid gap-2 col-12 mx-auto">
                      <a class="btn btn-block btn-secondary" href="logout.php" class="cikis-yap-link">Çıkış Yap</a>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
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
        <div class="row">
          <div class="col-md-4">
            <div class="card card--grey mt-3 auth-page--card">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-center mb-3">
                  <i class="fas fa-map-marker-alt"></i>
                  <span class="mx-3"><b>Kayıtlı Adreslerim</b></span>
                </div>

                <div class="d-flex align-items-center">
                  <i class="fas fa-home"></i>

                  <div class="mx-3">
                    <h6>Ev</h6>
                    <span>Çankaya (Emek Mah.)</span>
                  </div>
                </div>
              </div>
              <h6 class="card-footer card__footer--grey">
                <a href="">Yeni Adres Ekle</a>
              </h6>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card card--grey mt-3 auth-page--card">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-center mb-3">
                  <i class="far fa-calendar"></i>
                  <span class="mx-3"><b>Son Siparişlerim</b></span>
                </div>

                <div class="d-flex align-items-center mb-2">
                  <span class="badge p-2">8.7</span>
                  <span class="mx-2">Gupse Fırın & Cafe, Çankaya (Emek Mah.) - 19 gün
                    önce</span>
                </div>

                <div class="d-flex align-items-center mb-2">
                  <span class="badge p-2">9.3</span>
                  <span class="mx-2">Kafes Fırın, Çankaya (Anıttepe Mah.) - 29 gün
                    önce</span>
                </div>

                <div class="d-flex align-items-center mb-2">
                  <span class="badge p-2">8.4</span>
                  <span class="mx-2">Komagene Etsiz Çiğ Köfte, Çankaya (Emek Mah.) - 30 gün
                    önce</span>
                </div>

                <div class="d-flex align-items-center">
                  <span class="badge p-2">8.9</span>
                  <span class="mx-2">Bahçeli Tost Evi, Çankaya (Bahçelievler Mah.) - 1 ay
                    önce</span>
                </div>
              </div>

              <h6 class="card-footer card__footer--grey">
                <a href="">Daha fazlasını görüntüle</a>
              </h6>
            </div>
          </div>
        </div>
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


            <?php 
              // Restorant Listesinden en 5 kaydı çeker
              $getLast = $conn->prepare("Select restorant_name, city, district FROM restorants ORDER BY id LIMIT 5");
              $getLast->execute();
            ?>
            <div class="card card--yellow mt-3">
              <h6 class="card-header card__header--yellow text-white text-center">
                Yeni Eklenen Restoranlar
              </h6>
              <div class="card-body">
                <ul class="list">
                  <?php 
                    if($getLast->rowCount() > 0){
                      while($restorants = $getLast->fetch(PDO::FETCH_ASSOC)){ extract($restorants); ?>
                      <li class="list__item">
                        <a href="restorant.php?restorant=<?php echo $restorant_name ?>" class="link-danger text-decoration-none"><?php echo $restorant_name . ",  " . $city . "(" . $district . ")"; ?></a>
                      </li>
                  <?php
                      }
                    }
                  ?>
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
<?php } else {header("Location:index.php");} ?>
<?php include "footer.php"; ?>