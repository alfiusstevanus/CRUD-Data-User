<!-- dasdlsd -->
<?php
session_start();
include('server/connection.php');
if (isset($_SESSION['logged_in'])) {
    header('location: welcome.php');
    exit;
}
if (isset($_POST['register_btn'])) {
    header('location: register.html');
}
if (isset($_POST['login_btn'])) {

    $email = $_POST['user_email'];
    $password = ($_POST['user_password']);

    $query = "SELECT user_id, user_name, user_email, user_password, user_phone,
    user_address, user_city, user_photo FROM users
    WHERE user_email = ? AND user_password = ? LIMIT 1";

    $stmt_login = $conn->prepare($query);
    $stmt_login->bind_param('ss', $email, $password);


    if ($stmt_login->execute()) {

        $stmt_login->bind_result(
            $user_id,
            $user_name,
            $user_email,
            $user_password,
            $user_phone,
            $user_address,
            $user_city,
            $user_photo
        );
        $stmt_login->store_result();

        if ($stmt_login->num_rows() == 1) {

            $stmt_login->fetch();

            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            $_SESSION['user_email'] = $user_email;
            $_SESSION['user_phone'] = $user_phone;
            $_SESSION['user_address'] = $user_address;
            $_SESSION['user_city'] = $user_city;
            $_SESSION['user_photo'] = $user_photo;
            $_SESSION['logged_in'] = true;

            header('location: welcome.php?message=Logged in succesfully');
        } else {
            header('location: login.php?error=Could not verify your account!');
        }
    } else {
        header('location: login.php?error=Something went wrong!');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="icon/home.png" type="image/png">
</head>

<body>
    <section>
        <div class="container">
            <form id="login-form" method="POST" action="">
                <div>
                    <br>
                    <h3>Login</h3>
                    <div>
                        <p>Email</p>
                        <input type="email" name="user_email">
                    </div>
                    <div>
                        <p>Password</p>
                        <input type="password" name="user_password">
                    </div>
                    <?php if (isset($_GET['error'])) ?>
                    <div class="text-danger" role="alert">
                        <?php if (isset($_GET['error'])) {
                            echo $_GET['error'];
                        } ?>
                    </div>
                    <br>
                    <span>
                        <button type="submit" class="btn btn-primary id=" login-btn" name="login_btn">Login</button>
                        <br><br>
                        <p style="display: inline;">Belum Punya Akun ? </p>
                        <a href="register.html">Register</a>
                    </span>
                </div>
            </form>
        </div>
    </section>
</body>

</html>