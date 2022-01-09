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
                    <a href="logout.php" class="btn btn-secondary btn-block cikis-yap-link">Çıkış Yap</a>
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

        <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
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
            <div class="alert alert-warning mt-3" role="alert">
              <h6>En Çok Tercih Edilenler</h6>
              <p>
                Yemeksepeti kullanıcıları tarafından en çok sipariş edilen
                ve en çok favori olarak belirtilen ürünler.
              </p>
            </div>

            <div class="card">
              <div class="card-body row">
                <div class="col-md-3">
                  <img src="./asset/komagene_menu_1.jpg" alt="" class="img-fluid" />
                  <h6 class="mt-2">Çiğ Köfte Dürüm</h6>
                  <p>
                    90 gr. çiğ köfte, tek lavaş, seçeceğiniz 5 çeşit
                    garnitür, seçeceğiniz 2 çeşit sos
                  </p>

                  <h6 class="color-main">
                    13,00 TL
                    <span class="badge p-2 mx-1"><i class="fas fa-plus"></i>
                    </span>
                  </h6>
                </div>
                <div class="col-md-3">
                  <img src="./asset/komagene_menu_2.jpg" alt="" class="img-fluid" />
                  <h6 class="mt-2">Mega Çiğ Köfte Dürüm</h6>
                  <p>
                    125 gr. çiğ köfte, çift lavaş, seçeceğiniz 5 çeşit
                    garnitür, seçeceğiniz 2 çeşit sos
                  </p>

                  <h6 class="color-main">
                    16,50 TL
                    <span class="badge p-2 mx-1"><i class="fas fa-plus"></i>
                    </span>
                  </h6>
                </div>
                <div class="col-md-3">
                  <img src="./asset/komagene_menu_3.jpg" alt="" class="img-fluid" />
                  <h6 class="mt-2">Doritos'lu Çiğ Köfte Dürüm Menü</h6>
                  <p>
                    Doritos'lu Çiğ Köfte Dürüm (90 gr. çiğ köfte, Doritos
                    taco, tek lavaş, seçeceğiniz 5 çeşit garnitür,
                    seçeceğiniz 2 çeşit sos) + Komagene Ayran (19,5 cl.)
                  </p>

                  <h6 class="color-main">
                    20,00 TL
                    <span class="badge p-2 mx-1"><i class="fas fa-plus"></i>
                    </span>
                  </h6>
                </div>
                <div class="col-md-3">
                  <img src="./asset/komagene_menu_4.jpg" alt="" class="img-fluid" />
                  <h6 class="mt-2">Dürüm Menü</h6>
                  <p>
                    Çiğ Köfte Dürüm (90 gr. çiğ köfte, tek lavaş,
                    seçeceğiniz 5 çeşit garnitür, seçeceğiniz 2 çeşit sos) +
                    Komagene Ayran (19,5 cl.)
                  </p>

                  <h6 class="color-main">
                    17,00 TL
                    <span class="badge p-2 mx-1"><i class="fas fa-plus"></i>
                    </span>
                  </h6>
                </div>
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

<?php include "restorant_footer.php"; ?>