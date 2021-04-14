    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="login.css">
    </head>
    <body>
        <!-- log in php process -->
        <?php
            if($_GET["loginreq"]=='tr'){
                include("./database.php");
                echo "if1";
                $con = connection();
                $validate = validate_username($con,$_POST['username']);
                if($validate)
                {
                    #echo "if2";
                    header("location:./home.php");
                }
                else{
                    echo "wrong";
                }

            }
        ?>
        <!--regester php-->
        <?php
            if($_GET['regreq'] == 'tr'){
                header("location:./reg.php");
            }
        ?>




        <div class="header">
        <h1>Log in</h1><br>
        </div>
        <div class="form1">
        <form action="?loginreq=tr" method='post'>
        <input type="text" name="username" id="username" placeholder="username"><br>
        <input type="submit" value="login"><br>
        <a class="anchor" href="?regreq=tr">create acc.</a>
        </form>
        </div>
    </body>
    </html>