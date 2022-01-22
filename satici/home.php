<?php
session_start();
include "restorant_header.php";
require_once "../config.php";
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
                      <a href="add_food.php">Ürün Ekle</a>
                    </li>
                    <li class="mb-2">
                      <a href="">Adreslerim</a>
                    </li>
                    <li class="mb-2">
                      <a href="">Bilgilerim</a>
                    </li>
                    <li class="mb-2">
                      <a href="logout.php" class="btn btn-secondary btn-block cikis-yap-link">Çıkış Yap</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="card mt-3">
          <?php 
            $qs = $conn->prepare("SELECT * FROM orders WHERE restorant_name=:restorant_name AND stat='Sipariş Alındı'");
            $qs->bindParam(':restorant_name', $_SESSION['restorant_name']);
            $qs->execute();
            if($qs->rowCount() > 0){
              $n = $qs->rowCount();?>
              <div class="card-header card__header text-white">
                Gelen Siparişler <span class="badge badge-light"><?php echo $n; ?></span>
              </div>              
              <?php
              while($orders = $qs->fetch(PDO::FETCH_ASSOC)){ extract($orders);?>
              <div class="card-body">
                <?php 
                  $user_qs = $conn->prepare("SELECT firstname, lastname, city, district FROM users WHERE id=:id");
                  $user_qs->bindParam(":id", $person_id);
                  $user_qs->execute();
                  if($user_qs->rowCount() > 0){
                    $row = $user_qs->fetch();
                    $firstname = $row['firstname'];
                    $lastname = $row['lastname'];
                    $city = $row['city'];
                    $district = $row['district'];
                  }
                  $f_name = unserialize($food_name);
                  $f_number = unserialize($number_of_food);
                  ?>
                  <?php
                  echo '<span><i class="fas fa-cookie-bite"></i></span>';
                  $i = 0;
                  foreach($f_name as $f){
                  ?>
                    <div class="d-flex ">
                      <h6 class="color-main mx-1"><?php echo $f . "\t" . $f_number[$i]; ?></h6>
                    </div>
                    <?php
                    $i++;
                  }
                   echo '<h6 class="color-main mx-1">Toplam : '. $total_cost . '<span><i class="fas fa-lira-sign"></i></span></h6>';
              ?>
              <div class="row">
                <h6><?php echo "Adres : " . ucwords($firstname) . "\t" . strtoupper($lastname) . "(" . $city . "," . $district . ")" . "<br />"; ?></h6>
              </div>
              </div>
              <?php 
                
              }
            }
          ?>
          </div>
        </div>
        <div class="col-md-8 mt-3">
          <div class="d-flex restorant__info-card">
            <img src="../asset/komagene.jpg" style="width: 100px" class="img-fluid" />

            <div class="mx-4">
              <h3>Komagene Etsiz Çiğ Köfte, Çankaya (Emek Mah.)</h3>

              <div class="d-flex mt-5">
                <span class="badge p-2 badge--restorant mx-1">
                  <h6>Hız</h6>
                  <span>8.7</span>
                </span>

                <span class="badge p-2 mx-1">
                  <h6>Servis</h6>
                  <span>8.3</span>
                </span>

                <span class="badge p-2 mx-1">
                  <h6>Lezzet</h6>
                  <span>8.5</span>
                </span>

                <span class="mx-3">
                  <h6>Min Tutar</h6>
                  <span>12.5 TL</span>
                </span>

                <span class="mx-3">
                  <h6>Servis Süresi</h6>
                  <span>30-40 dk.</span>
                </span>
              </div>
            </div>
          </div>

          <?php
          $restorant_id = $_SESSION['restorant_id'];
          $query = $conn->prepare("SELECT DISTINCT food_category FROM restorant_menu WHERE restorant_id=:restorant_id");
          $query->execute(array(":restorant_id" => $restorant_id));
          ?>
          <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
                <h5>Başlıklar</h5>
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="menu-tab" data-bs-toggle="tab" data-bs-target="#menu" type="button" role="tab" aria-controls="menu" aria-selected="false">
                <h5>Menü</h5>
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                <h5>Bilgiler</h5>
              </button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <div class="row mt-3">
                <ul class="grid-list">
                  <?php
                  if ($query->rowCount() > 0) {
                    while ($result = $query->fetch(PDO::FETCH_ASSOC)) { ?>
                      <li class="color-main mb-2">
                        <h5><span class="pl-4"><i class="fab fa-youtube"></i></span><?php echo $result['food_category']; ?></h5>
                      </li>
                  <?php
                    }
                  }
                  ?>
                </ul>
              </div>
            </div>
            <?php
            // Gelen değeri boş değilse sorguyu çalıştır
            // delete parametresi gönderilen değeri tutuyor
            // IDOR koruması kendi id si eşleşleşmeyen kullanıcı silme işlemi gerçekleştiremez
            if (isset($_POST['delete'])) {
              $restorant_id = $_SESSION['restorant_id'];
              $query = $conn->prepare("DELETE FROM restorant_menu WHERE id = :id AND restorant_id = :restorant_id");
              $query->bindParam(":id", $_POST['delete']);
              $query->bindParam(":restorant_id", $restorant_id);
              $query->execute();
              if ($query->rowCount() > 0) {
                echo '<script>Swal.fire("Başarılı", "Kayıt Silindi", "success"); </script>';
              }
            }
            ?>
            <div class="tab-pane fade show" id="menu" role="tabpanel" aria-labelledby="menu-tab">
              <div class="card mt-3">
                <h5 class="card-header card__header card__header--yellow">
                  Menü
                </h5>
                <?php
                $stmt = $conn->prepare("SELECT * FROM restorant_menu WHERE restorant_id=:restorant_id");
                $stmt->execute(array(":restorant_id" => $restorant_id));
                ?>
                <div class="card-body">
                  <?php
                  if ($stmt->rowCount() > 0) {
                    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>

                      <div class="d-flex mx-auto">
                        <h5 class="flex-grow-1 p-2"><?php echo $res['food']; ?></h5>
                        <form method="POST" action="food_update.php">
                          <button type="submit" name="update" class="btn btn-labeled btn-info" value="<?php echo $res['id']; ?>">
                            <span class="btn-label"><i class="fas fa-pen"></i></span></button>
                        </form>
                        <form method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
                          <button type="submit" name="delete" class="btn btn-labeled btn-danger" value="<?php echo $res['id']; ?>">
                            <span class=" btn-label"><i class="fas fa-trash"></i></span></button>
                        </form>
                      </div>
                      <hr>

                  <?php
                    }
                  }
                  ?>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              <div class="d-flex mt-4">
                <span class="mx-3">
                  <h6>Min Tutar</h6>
                  <span><b>12.5 TL</b></span>
                </span>

                <span class="mx-3">
                  <h6>Çalışma Saatleri</h6>
                  <span class="color-main"><b>11:30 - 03:00</b></span>
                </span>

                <span class="mx-3">
                  <h6>Servis Süresi</h6>
                  <span><b>30-40 dakika</b></span>
                </span>
              </div>

              <div class="card mt-3">
                <h5 class="card-header card__header card__header--grey">
                  Promosyonlar
                </h5>

                <div class="card-body">
                  <ul>
                    <li class="list__item">
                      Sadece Yemeksepeti'nde, herhangi bir porsiyon çiğ köfte
                      alana 'Çiğ Köfte (100 gr.)' 5 TL farkla!
                    </li>
                    <li class="list__item">
                      Sadece Yemeksepeti'nde, 'Vodafone Menüsü (2 Ultra Mega
                      Dürüm)' 47 TL yerine sadece 37,5 TL! Tüm Vodafone’lulara
                      özel, indirimli Vodafone Menülerinden faydalanabilmek
                      için, siparişi tamamlamadan önce Vodafone hattınızın
                      numarasını ve Vodafone Yanımda mobil uygulaması
                      Fırsatlar Dünyası bölümünden aldığınız şifreyi sorgu
                      alanına girerek “Uygula”’ya tıklayın. İndirimlerin her
                      seferinde şifre girerek değil otomatik olarak
                      uygulanmasını istiyorsanız, ana sayfadaki “Vodafone
                      Menüleri” butonuna tıklayarak, karşınıza çıkan
                      görseldeki “Numaranı Gir” alanı ile numaranızı
                      kaydedebilirsiniz. Aksi halde seçtiğiniz Vodafone Menüsü
                      standart tutarı üzerinden indirimsiz
                      fiyatlandırılacaktır.
                    </li>
                  </ul>
                </div>
              </div>

              <div class="card mt-3">
                <h5 class="card-header card__header card__header--grey">
                  Uyarılar & Bilgiler
                </h5>

                <div class="card-body">
                  <ul>
                    <li class="list__item">
                      Siparişleriniz ortak gönderim alanları dahilinde farklı
                      bir şubeye yönlendirilebilir.
                    </li>
                    <li class="list__item">
                      Gökmeydan Mahallesi. Alanönü Mahallesi. Deliktaş
                      Mahallesi. Huzur Mahallesi Şeker Mahallesi bölgelerine
                      minimum paket gönderim tutarı 10 TL'dir.
                    </li>
                    <li class="list__item">
                      Çevre Kanunu kapsamında yapılan değişiklikle her bir
                      plastik poşetin en az 0,25 TL ek bedelle temin edilmesi
                      Çevre ve Şehircilik Bakanlığı tarafından zorunlu hale
                      getirilmiştir. Plastik poşet talep etmeniz halinde ürünü
                      sepete eklemeniz gerekmektedir. Sepete eklenen her bir
                      plastik poşet için ilgili bedel tarafınızdan tahsil
                      edilecektir.
                    </li>
                    <li class="list__item">
                      Balgat (Ziyabey Cad.), Balgat (Barış Manço Cad.)
                      bölgelerine minimum paket gönderim tutarı 13,5 TL'dir.
                    </li>
                    <li class="list__item">
                      Müşteri notu bölümüne yazılacak ekstra ürün istekleri
                      dikkate alınmayacaktır. Lütfen ekstra sos, lavaş ve
                      yeşillik isteklerinizi sepetinize ekleyiniz.
                    </li>
                  </ul>
                </div>
              </div>

              <div class="card mt-3">
                <h5 class="card-header card__header card__header--grey">
                  Ödeme Şekilleri
                </h5>

                <div class="card-body">
                  <ul>
                    <li class="list__item">Online Kredi/Banka Kartı</li>
                    <li class="list__item">Maximum Mobil ile Öde</li>
                    <li class="list__item">Nakit</li>
                    <li class="list__item">Kredi Kartı</li>
                    <li class="list__item">Cüzdan</li>
                  </ul>
                </div>
              </div>

              <div class="card mt-3">
                <h5 class="card-header card__header card__header--grey">
                  Bilgiler
                </h5>

                <div class="card-body">
                  <ul>
                    <li class="list__item"><b>Kep Adresi: </b>---</li>
                    <li class="list__item">
                      <b>İşletme Adı: </b>Komagene Etsiz Çiğ Köfte
                    </li>
                    <li class="list__item">
                      <b>Vergi No / Mersis Numarası: </b>---
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script>
    function formGoster() {
      var x = document.getElementById("formDiv");
      if (x.style.display === "none") {
        x.style.display = "block";
      } else {
        x.style.display = "none";
      }
    }
  </script>
<?php } else {
  header("Location: login.php");
}
include "restorant_footer.php";
?>