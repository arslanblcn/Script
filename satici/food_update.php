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
                                            <a href="add_food.php">??r??n Ekle</a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="">Adreslerim</a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="">Bilgilerim</a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="logout.php" class="btn btn-secondary btn-block cikis-yap-link">????k???? Yap</a>
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
                            <p class="card-text mx-3">Sepetiniz hen??z bo??.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 mt-3">
                    <div class="d-flex restorant__info-card">
                        <img src="../asset/komagene.jpg" style="width: 100px" class="img-fluid" />

                        <div class="mx-4">
                            <h3>Komagene Etsiz ??i?? K??fte, ??ankaya (Emek Mah.)</h3>

                            <div class="d-flex mt-5">
                                <span class="badge p-2 badge--restorant mx-1">
                                    <h6>H??z</h6>
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
                                    <h6>Servis S??resi</h6>
                                    <span>30-40 dk.</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (isset($_POST['submit'])) {
                        $id = htmlspecialchars(trim($_POST['id']));
                        $food_name = htmlspecialchars(trim($_POST['yemek_adi']));
                        $img = $_FILES["yemek_gorsel"]["name"];
                        $type = $_FILES["yemek_gorsel"]["type"];
                        $size = $_FILES["yemek_gorsel"]["size"];
                        $temp = $_FILES["yemek_gorsel"]["tmp_name"];
                        $path = "uploads/" . $img;
                        $allowed_types = array("image/jpeg", "image/png", "image/jpg");
                        $food_category = htmlspecialchars(trim($_POST['yemek_kategori']));
                        $food_option = implode(", ",  $_POST['yemekBoyutu']);
                        $food_cost = htmlspecialchars(trim($_POST['yemek_tutar']));
                        $restorant_id = $_SESSION['restorant_id'];
                        if (!empty($_POST['ekstra_yemek_adi']) && !empty($_POST['ekstra_yemek_fiyati'])) {
                            $extra_food_name = htmlspecialchars(trim($_POST['ekstra_yemek_adi']));
                            $extra_food_cost = htmlspecialchars(trim($_POST['ekstra_yemek_fiyati']));
                        } else {
                            $extra_food_name = null;
                            $extra_food_cost = null;
                        }
                        try {
                            //--------------Ekleme i??lemleri-------------
                            // ??zin verilen dosya tipleri ve boyutu 5mb dan d??????k ise klas??re ta???? ve ekleme yap
                            move_uploaded_file($temp, $path);
                            $stmt = $conn->prepare("UPDATE restorant_menu SET food=:food, food_img=:food_img, food_cost=:food_cost, food_category=:food_category, food_options=:food_options, 
                                extra_food_name=:extra_food_name, extra_food_cost=:extra_food_cost WHERE id=:id AND restorant_id=:restorant_id");
                            $stmt->bindParam(':food', $food_name, PDO::PARAM_STR);
                            $stmt->bindParam(':food_img', $img);
                            $stmt->bindParam(':food_cost', $food_cost, PDO::PARAM_STR);
                            $stmt->bindParam(':food_category', $food_category, PDO::PARAM_STR);
                            $stmt->bindParam(':food_options', $food_option, PDO::PARAM_STR);
                            $stmt->bindParam(':extra_food_name', $extra_food_name, PDO::PARAM_STR);
                            $stmt->bindParam(':extra_food_cost', $extra_food_cost, PDO::PARAM_STR);
                            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                            $stmt->bindParam(':restorant_id', $restorant_id, PDO::PARAM_INT);
                            $stmt->execute();
                            if ($stmt->rowCount() > 0) {
                                echo '<script>Swal.fire("Ba??ar??l??", "G??ncelleme i??lemi Ba??ar??l??.", "success").then(function() {
                                    window.location = "home.php";
                                }); </script>';
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                    }
                    $kategori_arr = array(
                        "G??zleme" => "G??zleme",
                        "Kepablar & Izgaralar" => "Kepablar & Izgaralar",
                        "Pideler" => "Pideler",
                        "Burgerler" => "Burgerler",
                        "????ecekler" => "????ecekler",
                        "??orbalar" => "??orbalar",
                        "Sulu Yemekler" => "Sulu Yemekler",
                        "F??r??n ??r??nleri" => "F??r??n ??r??nleri",
                    );
                    // Update form tetiklendi??inde yeni bir form olu??turur
                    // i??erisine veriler eklenir
                    if (isset($_POST['update'])) {
                        $item = htmlspecialchars(trim($_POST['update']));
                        $kategori_arr = array(
                            "G??zleme" => "G??zleme",
                            "Kepablar & Izgaralar" => "Kepablar & Izgaralar",
                            "Pideler" => "Pideler",
                            "Burgerler" => "Burgerler",
                            "????ecekler" => "????ecekler",
                            "??orbalar" => "??orbalar",
                            "Sulu Yemekler" => "Sulu Yemekler",
                            "F??r??n ??r??nleri" => "F??r??n ??r??nleri",
                        );
                        $stmt = $conn->prepare("SELECT * FROM restorant_menu WHERE id = :id");
                        $stmt->bindParam(":id", $item);
                        $stmt->execute();
                        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($result);
                    ?>
                            <div class="row justify-content-center h-100 mt-3">
                                <div class="col-12 col-lg-9 col-xl-7">
                                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                        <div class="card-body p-4 p-md-5">
                                            <div class="row">
                                                <div class="col-md-6 mb-4 ">
                                                    <h3 class="">Yemek Ekle</h3>
                                                </div>
                                            </div>
                                            <form method="POST" action="<?= $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-6 mb-4">
                                                        <div class="form-outline">
                                                            <input type="text" name="yemek_adi" id="yemek_adi" class="form-control" value="<?php echo $food ?>" />
                                                            <label class="form-label" for="yemek_adi">Yemek Ad??</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <div class="form-outline">
                                                            <input class="form-control" type="file" name="yemek_gorsel" id="yemek_gorsel" value="uploads/<?php echo $food_img; ?>" />
                                                            <p><img src="uploads/<?php echo $food_img; ?>" alt="" width="50px" height="50px"></p>
                                                            <label for="yemek_gorsel" class="form-label">Yemek G??rsel</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-4">
                                                        <div class="form-outline">
                                                            <select class="form-select" name="yemek_kategori" id="yemek_kategori">
                                                                <option value="<?php echo $food_category; ?>"><?php echo $food_category; ?></option>
                                                                <?php
                                                                foreach ($kategori_arr as $kategori) {
                                                                    echo "<option value=\"$kategori\">$kategori</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                            <label class="form-label" for="yemek_kategori">Yemek Kategorisi</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="yemekBoyutu[]" id="yemek_boyut_1" value="K??????k" <?php if (str_contains($food_options, "K??????k")) {
                                                                                                                                                                        echo "checked";
                                                                                                                                                                    } ?>>
                                                            <label class="form-check-label" for="yemek_boyut_1">K??????k</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="yemekBoyutu[]" id="yemek_boyut_2" value="Orta" <?php if (str_contains($food_options, "Orta")) {
                                                                                                                                                                        echo "checked";
                                                                                                                                                                    } ?>>
                                                            <label class="form-check-label" for="yemek_boyut_2">Orta</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="yemekBoyutu[]" id="yemek_boyut_3" value="B??y??k" <?php if (str_contains($food_options, "B??y??k")) {
                                                                                                                                                                        echo "checked";
                                                                                                                                                                    } ?>>
                                                            <label class="form-check-label" for="yemek_boyut_3">B??y??k</label>
                                                        </div>
                                                        <p class="mt-2">Yemek Porsiyon</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 mt-3 mb-4">
                                                        <div class="form-outline">
                                                            <input type="text" name="yemek_tutar" id="yemek_tutar" class="form-control" value="<?php echo $food_cost; ?>" />
                                                            <label class="form-label" for="yemek_tutar">Yemek Tutar</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-4">
                                                        <div class="form-outline">
                                                            <input type="text" name="ekstra_yemek_adi" id="ekstra_yemek_adi" class="form-control" value="<?php echo $extra_food_name; ?>" placeholder="Virg??l ile ??oklu giri?? yapabilirsiniz" />
                                                            <label class="form-label" for="ekstra_yemek_adi">Ekstra Yemek Ad??</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <div class="form-outline">
                                                            <input type="text" name="ekstra_yemek_fiyati" id="ekstra_yemek_fiyati" value="<?php echo $extra_food_cost; ?>" class="form-control" />
                                                            <label class="form-label" for="ekstra_yemek_fiyati">Ekstra Yemek Fiyat??</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                                                <div class="mt-4 pt-2">
                                                    <input class="btn btn-success" type="submit" name="submit" value="Submit" />
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
    </main>
<?php
                        }
                    }
?>
<?php } else {
    header("Location: login.php");
}
include "restorant_footer.php";
?>