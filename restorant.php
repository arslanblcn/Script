<?php
session_start();
require_once "config.php";
include "header.php";
if (isset($_SESSION['username'])) {
    if(isset($_GET['clear'])){
        unset($_SESSION['item']);
        echo '<script>Swal.fire("Başarılı", "Sepetiniz şimdi boş.", "success"); </script>';
        header("Refresh: 3; url=" . $_SERVER['HTTP_REFERER']);
    }
    if(isset($_GET['order'])){
        unset($_SESSION['item']);
        echo '<script>Swal.fire("Başarılı", "Siparişiniz başarıyla alınmıştır", "success"); </script>';
        header("Refresh: 3; url=" . $_SERVER['HTTP_REFERER']);
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
                                            <h6 class="text-capitalize color-main"><?php echo $_SESSION['ad'] . " " . $_SESSION['soyad']; ?></h6>
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
                            <div class="d-flex justify-content-between">
                                <h5>Sepetim</h5>
                                <a href="<?= $_SERVER['REQUEST_URI']; ?>&clear" class="btn btn-sm btn-danger"><span><i class="fas fa-trash-alt"></i></span></a>
                            </div>
                        </div>
                        <div class="card-body d-flex align-items-center">
                            <form action="order.php" method="POST">
                                <?php
                                if(!empty($_SESSION['error'])){
                                    echo '<script>Swal.fire("Dikkat", "'. $_SESSION['error'] . '", "warning"); </script>';
                                    unset($_SESSION['error']);
                                }
                                if (isset($_SESSION['item'])) {
                                    $temp = 0;
                                    $restorant_name = htmlspecialchars(trim($_GET['restorant']));
                                    ?>  
                                        <div class="text-warning">
                                            <input type="text" name="restorant_name" value="<?php echo $restorant_name; ?>" class="form-control mb-3" readonly>
                                        </div>
                                    <?php
                                    foreach ($_SESSION['item'] as $item) {
                                        if (isset($item['number_of_food']) && $item['number_of_food'] != 0) {
                                            $temp += $item['food_cost'];
                                ?>
                                        <div class="d-flex justify-content-between mb-3 mr-3">
                                            <input type="text" class="border-0 color-main" style="width: 18rem;" name="food_name[]" value="<?php echo $item['food_name']; ?>" readonly>
                                            <input type="number" id="number_of_food" name="number_of_food[]" min="1" max="100" value="<?php echo $item['number_of_food']; ?>">
                                            <span class="color-main mt-1"><?php echo number_format($item['food_cost'], 2); ?><i class="fas fa-lira-sign"></i></span>
                                            <input type="hidden" name="total_cost" value="<?php echo $temp; ?>">
                                        </div>
                                    <?php
                                        }
                                    }
                                    echo '<hr>';?>
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" name="giveOrder" class="btn btn-block btn-success">Siparişi Tamamla</button>
                                        <h5 class="color-main">Toplam : <?php echo number_format($temp, 2); ?><span><i class="fas fa-lira-sign"></i></span></h5>
                                    </div>
                                <?php } else { ?>
                                    <i class="fas fa-shopping-basket"></i>
                                    <p class="card-text mx-3">Sepetiniz henüz boş.</p>
                                <?php
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
                if (isset($_GET["restorant"])) {
                    $r_name = htmlspecialchars(trim($_GET["restorant"]));
                    $getRestorant = $conn->prepare("SELECT id, city, district FROM restorants WHERE restorant_name=:restorant_name");
                    $getRestorant->bindParam(":restorant_name", $r_name);
                    $getRestorant->execute();
                    if ($getRestorant->rowCount() > 0) {
                        while ($r = $getRestorant->fetch(PDO::FETCH_ASSOC)) {
                            $r_id = $r['id'];
                            $r_city = $r['city'];
                            $r_district = $r['district'];
                        }
                    }
                }
                ?>
                <div class="col-md-8 mt-3">
                    <div class="d-flex restorant__info-card">
                        <img src="./asset/komagene.jpg" style="width: 100px" class="img-fluid" />

                        <div class="mx-4">
                            <h3 class="text-danger"><?php echo $r_name . " (" . $r_city . "," . $r_district . ")" ?></h3>

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

                                <span class="mx-3 text-light">
                                    <h6>Min Tutar</h6>
                                    <span>12.5 TL</span>
                                </span>

                                <span class="mx-3 text-light">
                                    <h6>Servis Süresi</h6>
                                    <span>30-40 dk.</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <?php
                    $query = $conn->prepare("SELECT DISTINCT food_category FROM restorant_menu WHERE restorant_id=:restorant_id");
                    $query->execute(array(":restorant_id" => $r_id));
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
                        <div class="tab-pane fade show" id="menu" role="tabpanel" aria-labelledby="menu-tab">
                            <div class="card mt-3">
                                <h5 class="card-header card__header card__header--yellow">
                                    Menü
                                </h5>
                                <?php
                                $stmt = $conn->prepare("SELECT * FROM restorant_menu WHERE restorant_id=:restorant_id");
                                $stmt->execute(array(":restorant_id" => $r_id));
                                ?>
                                <div class="card-body">
                                    <?php
                                    if ($stmt->rowCount() > 0) {
                                        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <form action="insertCart.php" method="POST">
                                                <div class="d-flex mx-auto">
                                                    <button type="submit" name="addCart" class="btn btn-sm btn-success btn-block p-3 m-1"><i class="fas fa-plus-square fa-lg"></i></button>
                                                    <input type="number" id="number_of_food" name="number_of_food" min="1" max="100">
                                                    <h5 class="flex-grow-1 p-2"><?php echo $res['food']; ?></h5>
                                                    <input type="hidden" name="food_name" value="<?php echo $res['food']; ?>">
                                                    <input type="text" class="border-0 color-main" name="food_cost" value="<?php echo $res['food_cost']; ?>" readonly>

                                                </div>
                                            </form>
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

                <div class="col-md-1 position-relative">
                    <img src="./asset/main-page-adv-3.png" class="img-fluid" />
                </div>
            </div>
        </div>
    </main>
<?php } else {
    header("Location:index.php");
} ?>
<?php include "footer.php"; ?>