<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>reg</title>
    <link rel="stylesheet" href="./reg.css">
</head>
<body>

    <!-- reg process -->
    <?php
        if($_GET['regsubmit'] == 'tr'){
            include('./database.php');
            $con = connection();
            $created = insert_user($con,$_POST['r-username']);
            $inserted = start_entry($con,$_POST['r-username'],$_POST['r-entryrs']);
            echo "<br>done<br>";
        }
    ?>

    <div class="header">
    <h1>Create New User</h1>
    </div>
    <br>
    <div class="form-cont">
    <form action="?regsubmit=tr" method="post">
    <input type="text" name="r-username" placeholder="enter user name"><br>
    <input type="number" name="r-entryrs" placeholder="enter the money you want at start"><br>
    <input type="submit" value="register">
    </form>
    </div>
</body>
</html>