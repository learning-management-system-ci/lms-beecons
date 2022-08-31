<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="style/login.css">
</head>

<body>
    <main class="page-flex d-flex justify-content-center align-items-center">
        <section class="image">
            <div class="square"></div>
        </section>
        <section style="border: 2px solid rgba(0, 0, 0, 0);">
            <h3 class="logo">LOGO</h3>
            <form action="" class=" form d-flex flex-column" style="border: 2px solid rgba(236, 236, 236, 0);">
                <p class="welcome-text">Welcome</p>
                <p class="sign-in-text">Sign Up</p>
                <p class="info-text">Please input your email and password</p>
                <label for="user_email" class="form-label">Email</label>
                <input type="text" name="email" id="user_email" placeholder="Email">
                <label for="user_pass" class="form-label mt-3">Password</label>
                <input type="password" name="pass" id="user_pass" placeholder="Password">
                <div class="option d-flex justify-content-between align-items-center">
                    <div class="checkbox d-flex align-items-center">
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Remember Me</label><br>
                    </div>
                    <a href="#">Forgot Password?</a>
                </div>
                <button type="button" class="btn btn-primary">Sign in</button>
                <p class="sign-up" style="text-align: center;">Don't Have Account <a href="#">Sign up</a></p>
                <p class="horizontal">Or</p>
                <button class="google"><img src="image/google.png" alt=""></button>
            </form>

        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>