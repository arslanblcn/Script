<?php
require_once "config.php";
include "header.php";
$password = "";
$firstName = "";
$lastName = "";
$email = "";
$il = "";
$ilce = "";
$confirmPassword = "";
if (isset($_REQUEST['submit'])) {
    $firstName = htmlspecialchars($_REQUEST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $email = htmlspecialchars($_POST['email']);
    $il = htmlspecialchars($_POST['il']);
    $ilce = htmlspecialchars($_POST['ilce']);
    $password = htmlspecialchars($_POST['password']);
    $confirmPassword = htmlspecialchars($_POST['confirmPassword']);

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
            if ($stmt) {
                echo '<script>Swal.fire("Başarılı", "Kaydınız Başarı ile Gerçekleşmiştir", "success"); </script>';
            }
        }
    }
}
//echo "$firstName / $lastName / $email / $il / $ilce / $password / $confirmPassword";
?>
<nav aria-label="breadcrumb" class="bg-white" style="height : 80px;">
    <ol class="breadcrumb justify-content-center pt-5">
        <li class="breadcrumb-item"><a href="index.php" class="display-5 link-danger">Login</a></li>
        <li class="breadcrumb-item text-dark display-5 active" aria-current="page">Kayıt Ol</li>
    </ol>
</nav>
<main>
    <div class="container mt-4">
        <div class="row mt-3">
            <div class="col-md-3 mt-3"></div>
            <div class="col-md-5">
                <div class="row">
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
                                <div class="mb-3">
                                    <label for="confirmPasswordInputLabel" class="form-label">Şifre Tekrar</label>
                                    <input type="password" name="confirmPassword" class="form-control" id="confirmPasswordInputLabel" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="firstName">Ad</label>
                                    <input type="text" name="firstName" id="firstName" class="form-control" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="lastName">Soyad</label>
                                    <input type="text" name="lastName" id="lastName" class="form-control" />
                                </div>
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
                                <button class="btn btn-success d-block" type="submit" name="submit">Üye Ol</button>
                            </form>
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
<script>
    $.getJSON("il-bolge.json", function(sonuc) {
        $.each(sonuc, function(index, value) {
            var row = "";
            row += '<option value="' + value.il + '">' + value.il + '</option>';
            $("#il").append(row);
        })
    });
    $("#il").on("change", function() {
        var il = $(this).val();
        $("#ilce").attr("disabled", false).html("<option value=''>Seçin..</option>");
        $.getJSON("il-ilce.json", function(sonuc) {
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