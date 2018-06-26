<?php

session_start();

if (isset($_SESSION['username'])) {

    header('Location: ../korisnici.php');

} else {

    require '../baza/Database.php';

    if (!empty($_POST)) {

        // keep track validation errors
        $emailError = null;
        $passwordError = null;

        // keep track post values
        $email = htmlspecialchars($_POST['email']);
        $password = md5(htmlspecialchars($_POST['lozinka']));

        // validate input
        $valid = true;

        if (empty($email)) {

            $emailError = 'Unesite vašu email adresu';
            $valid = false;

        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $emailError = 'Unesite validnu email adresu';
            $valid = false;

        }

        if (empty($password)) {

            $passwordError = 'Unesite vašu lozinku';
            $valid = false;

        }

        // check data
        if ($valid) {

            try {

                $pdo = Database::connect();

                $query = $pdo->prepare('SELECT metHotels.Korisnici.korisnik_email
                                              FROM metHotels.Korisnici
                                              WHERE metHotels.Korisnici.korisnik_email = :email');

                $query->bindParam(':email', $email);

                $query->execute();

                $row_email = $query->fetch();

                $query = $pdo->prepare('SELECT metHotels.Korisnici.korisnik_lozinka
                                              FROM metHotels.Korisnici
                                              WHERE metHotels.Korisnici.korisnik_lozinka = :lozinka');

                $query->bindParam(':lozinka', $password);

                $query->execute();

                $row_password = $query->fetch();


                if ($row_email['korisnik_email'] != $email) {

                    $emailError = 'Pogresna email adresa';
                    $valid = false;

                }

                if ($row_password['korisnik_lozinka'] != $password) {

                    $passwordError = 'Pogresna lozinka';
                    $valid = false;

                }


                if ($row_email['korisnik_email'] == $email && $row_password['korisnik_lozinka'] == $password) {

                    $_SESSION['username'] = $email;
                    header('Location: ../korisnici.php');

                }

                Database::disconnect();

            } catch (PDOException $e) {

                echo $e->getMessage();

            }
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
  <title>MetHotels</title>
</head>

<body class="bg-light">

  <!-- Jumbotron -->
  <div class="container">
    <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner rounded">
        <div class="carousel-item active">
          <img class="d-block w-100" src="../../slike/3.svg" alt="First slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="../../slike/2.svg" alt="Second slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="../../slike/11.svg" alt="Third slide">
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
    </div>
  </div>
  <!-- Jumbotron -->


  <!-- Stranica -->
  <div class="container">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-warning rounded-bottom sticky-top" style="box-shadow: 1.5px 2.5px 4.5px rgba(0, 0, 0, 0.5);">
      <a class="navbar-brand" href="index.html"><h4 class="mb-0">MetHotels</h4></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Početna <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Rezervacije</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">O nama</a>
          </li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Gost
                    </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="../registracija/registracija.php">Regstracija</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- Navbar -->

    <!-- Sadrzaj stranice -->
    <!--Prijava-->
    <div class="container m-5" style="margin-top: 10%">
        <div class="row">
            <h3>Prijavi se</h3>
        </div>

        <div class="row" style="width: 300px; ">
            <form class="form-horizontal" action="prijava.php" method="post">

                <div class="control-group <?php echo !empty($emailError) ? 'error' : ''; ?>">
                    <label class="control-label">Email adresa</label>
                    <div class="controls text-danger">
                        <input class="form-control" name="email" type="text" placeholder="Vaša email adresa"
                               value="<?php echo !empty($email) ? $email : ''; ?>">
                        <?php if (!empty($emailError)): ?>
                            <span class="help-inline"><?php echo $emailError; ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="control-group <?php echo !empty($passwordError) ? 'error' : ''; ?>">
                    <label class="control-label">Lozinka</label>
                    <div class="controls text-danger">
                        <input class="form-control" name="lozinka" type="password" placeholder="Vaša lozinka">
                        <?php if (!empty($passwordError)): ?>
                            <span class="help-inline"><?php echo $passwordError; ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <br>

                <div class="form-actions" style="float: right">
                    <button type="submit" class="btn btn-success">Prijavi se</button>
                </div>

            </form>
        </div>
    </div>
    <!--Prijava-->
    <!-- Sadrzaj stranice -->

    <!-- Footer -->
    <footer class="footer bg-dark">
        <p class="text-light mb-0">Copyright &copy; MetHotels</p>
    </footer>
    <!-- Footer -->

</div>
<!-- Stranica -->

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
</body>


</html>
