<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <title><?= $title ?></title>
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="style/login.css">
</head>

<body>
    <main class="page-flex d-flex justify-content-center align-items-center">
        <section class="image">
            <img src="image/auth-image.png" width="600px">
        </section>
        <section style="border: 2px solid rgba(0, 0, 0, 0);" class="d-flex">
            <div class="form-wrap">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
                </script>
                <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
                <?= $this->renderSection('authentication-component') ?>
                <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
                <script src="https://accounts.google.com/gsi/client" async defer></script>
                <?= $this->renderSection('authentication-js-logic') ?>
                <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
                <?= $this->renderSection('authentication-js') ?>
            </div>
            <div class="logo">
                <h3>LOGO</h3>
            </div>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
</body>

</html>