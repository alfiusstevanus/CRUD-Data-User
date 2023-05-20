<?php
session_start();
include('server/connection.php');

$sql = "Select * from users";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['cari'])) {
    $keyword = $_POST['keyword'];
    $q = "Select * from users where user_id LIKE '%$keyword%' or
    user_name LIKE '%$keyword%' or user_email LIKE '%$keyword%'";
} else {
    $q = 'Select * from users';
}

$result = mysqli_query($conn, $q);

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

if (isset($_GET['logout'])) {
    if (isset($_SESSION['logged_in'])) {
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        header('location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page </title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="icon/home.png" type="image/png">
</head>

<body>
    <div class="container" id="block">
        <br><br>
        <form class="search ml-200 " action="" method="post">
            <input type="text" name="keyword" placeholder="Masukan keyword">
            <button type="submit" class="btn btn-success" name="cari">Cari</button>
        </form>
        <br><br>
        <table class="table table-warning ">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['user_id'] ?></td>
                        <td><?php echo $row['user_name'] ?></td>
                        <td><?php echo $row['user_email'] ?></td>
                        <td>
                            <a class="text-danger" href="actionDelete.php?user_id=<?= $row['user_id']; ?>" role="button" onclick="return confirm('Data ini akan dihapus?')">Hapus</a> |
                            <a class="text-secondary" href="Update.php?user_id=<?= $row['user_id']; ?>&user_name=<?= $row['user_name']; ?>&user_email=<?= $row['user_email']; ?>">Edit</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <br>
        <div id="center">
            <a class="btn btn-danger" href="index.php?logout=3" role="button">Log out</a>
        </div>
    </div>
</body>

</html>