<?php
session_start();
require_once "../config.php";
if (isset($_SESSION['username'])) { ?>
    <!doctype html>
    <html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <title>Home Page</title>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <a class="navbar-brand" href="#">Pidesepeti</a>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <div class="dropdown mx-3">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="yemekDropDown" data-bs-toggle="dropdown" aria-expanded="false">
                                İşlemler
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="yemekDropDown">
                                <li><a class="dropdown-item" href="yemek_ekle.php">Yemek Ekle</a></li>
                                <li><a class="dropdown-item" href="yemek_listele.php">Yemek Listele</a></li>
                            </ul>
                        </div>
                    </ul>
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    <div class="dropdown mx-3">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $_SESSION['email']; ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>


        <?php
        $kategori_arr = array(
            "Gözleme" => "Gözleme",
            "Kepablar & Izgaralar" => "Kepablar & Izgaralar",
            "Pideler" => "Pideler",
            "Burgerler" => "Burgerler",
            "İçecekler" => "İçecekler",
            "Çorbalar" => "Çorbalar",
            "Sulu Yemekler" => "Sulu Yemekler",
            "Fırın Ürünleri" => "Fırın Ürünleri",
        );

        if (isset($_POST['submit'])) {
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
            $restorant_id = $_SESSION['id'];
            if (!empty($_POST['ekstra_yemek_adi']) && !empty($_POST['ekstra_yemek_fiyati'])) {
                $extra_food_name = htmlspecialchars(trim($_POST['ekstra_yemek_adi']));
                $extra_food_cost = htmlspecialchars(trim($_POST['ekstra_yemek_fiyati']));
            } else {
                $extra_food_name = null;
                $extra_food_cost = null;
            }
            try {
                //--------------Ekleme işlemleri-------------
                // İzin verilen dosya tipleri ve boyutu 5mb dan düşük ise klasöre taşı ve ekleme yap
                if (!in_array($type, $allowed_types)) {
                    echo '<script>Swal.fire("Hata", "Yanlış dosya formatı. JPEG, PNG kullanılabilir.", "error"); </script>';
                } else {
                    if (!file_exists($path)) {
                        if ($size < 5000000) {
                            move_uploaded_file($temp, $path);
                            $stmt = $conn->prepare("INSERT INTO restorant_menu (food, food_img, food_cost, food_category, food_options, 
                            extra_food_name, extra_food_cost, restorant_id) VALUES (:food, :food_img, :food_cost, :food_category, :food_options, 
                            :extra_food_name, :extra_food_cost, :restorant_id)");
                            $stmt->bindParam(':food', $food_name, PDO::PARAM_STR);
                            $stmt->bindParam(':food_img', $img);
                            $stmt->bindParam(':food_cost', $food_cost, PDO::PARAM_STR);
                            $stmt->bindParam(':food_category', $food_category, PDO::PARAM_STR);
                            $stmt->bindParam(':food_options', $food_option, PDO::PARAM_STR);
                            $stmt->bindParam(':extra_food_name', $extra_food_name, PDO::PARAM_STR);
                            $stmt->bindParam(':extra_food_cost', $extra_food_cost, PDO::PARAM_STR);
                            $stmt->bindParam(':restorant_id', $restorant_id, PDO::PARAM_INT);
                            if($stmt->execute()){
                                echo '<script>Swal.fire("Başarılı", "Yemek Başarılı bir şekilde eklendi.", "success"); </script>';
                            }
                            
                        } else {
                            echo '<script>Swal.fire("Hata", "Dosya boyutu 5MB\'dan düşük olmalıdır.", "error"); </script>';
                        }
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        ?>
        <section class="vh-100 gradient-custom">
            <div class="container py-5 h-100">
                <div class="row justify-content-center h-100">
                    <div class="col-12 col-lg-9 col-xl-7">
                        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                            <div class="card-body p-4 p-md-5">
                                <div class="row">
                                    <div class="col-md-6 mb-4 ">
                                        <h3 class="">Yemek Ekle</h3>
                                    </div>
                                    <div class="col-md-6 mb-4 d-flex justify-content-end">
                                        <button class="btn btn-primary" onclick="formGoster()"><i class="bi bi-bag-plus-fill"> Ekstra Ürün Ekle</i></button>
                                    </div>
                                </div>
                                <form method="POST" action="<?= $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-outline">
                                                <input type="text" name="yemek_adi" id="yemek_adi" class="form-control" />
                                                <label class="form-label" for="yemek_adi">Yemek Adı</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-outline">
                                                <input class="form-control" type="file" name="yemek_gorsel" id="yemek_gorsel" />
                                                <label for="yemek_gorsel" class="form-label">Yemek Görsel</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-outline">
                                                <select class="form-select" name="yemek_kategori" id="yemek_kategori">
                                                    <option value="">Seçiniz</option>
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
                                                <input class="form-check-input" type="checkbox" name="yemekBoyutu[]" id="yemek_boyut_1" value="Küçük">
                                                <label class="form-check-label" for="yemek_boyut_1">Küçük</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="yemekBoyutu[]" id="yemek_boyut_2" value="Orta">
                                                <label class="form-check-label" for="yemek_boyut_2">Orta</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="yemekBoyutu[]" id="yemek_boyut_3" value="Büyük">
                                                <label class="form-check-label" for="yemek_boyut_3">Büyük</label>
                                            </div>
                                            <p class="mt-2">Yemek Porsiyon</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-3 mb-4">
                                            <div class="form-outline">
                                                <input type="text" name="yemek_tutar" id="yemek_tutar" class="form-control" />
                                                <label class="form-label" for="yemek_tutar">Yemek Tutar</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="formDiv" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input type="text" name="ekstra_yemek_adi" id="ekstra_yemek_adi" class="form-control" placeholder="Virgül ile çoklu giriş yapabilirsiniz" />
                                                    <label class="form-label" for="ekstra_yemek_adi">Ekstra Yemek Adı</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input type="text" name="ekstra_yemek_fiyati" id="ekstra_yemek_fiyati" class="form-control" />
                                                    <label class="form-label" for="ekstra_yemek_fiyati">Ekstra Yemek Fiyatı</label>
                                                </div>
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
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
    </body>

    </html>
<?php } else {
    header("Refresh: 2; url=login.php");
}
?>