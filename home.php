<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="home.css">

    <title>Home</title>
</head>
<body>
    <div class="container">
    <div class="header">Wallet Manager
    <br><p>Manage your wallet and track your spending eaysely
    </div><br>

    <div class="userdata">
    <fieldset><legend>User Data</legend>
    <?php
        echo "<p>Username : ".$_COOKIE["current_user"];
        echo "<br><p>Userid : ".$_COOKIE["current_id"];
        echo "<p>wallet Money : ".$_COOKIE["rem_amount"];
    ?>
    </filedset>
    </div>
    <br>
    
    <!--user controls-->
    <div class="usercontrol">
    <fieldset><legend>User Control</legend>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-money-modal">
        add_money
    </button>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#spent-money-modal">
        Spent_money
    </button>
    </fieldset>
    </div>
    

    
    <!-- table visual -->
    <?php
        include("./database.php");
        $data = fetchdata(connection(),$_COOKIE["current_user"]);
        #echo var_dump($data);
        $row = $data->fetch_all(MYSQLI_ASSOC);
        
    ?>

    <!-- table --> 
    <div class=stat>
    <fieldset>
    <legend>Statestics</legend>
    <table>
    <thead>
        <td>id</td>
        <td>date</td>
        <td>spent</td>
        <td>added</td>
        <td>description</td>
        <td>remaiming</td>
    </thead>
    <?php
    if($data->num_rows <11){
    for ($i=0; $i < $data->num_rows ; $i++) { 
       echo ' <tr>
       <td>'.$row[$i]["entryid"].'</td>
       <td>'.$row[$i]["date"].'</td>
       <td>'.$row[$i]["spent"].'</td>
       <td>'.$row[$i]["added"].'</td>
        <td>'.$row[$i]["desc"].'</td>
        <td>'.$row[$i]["wall_money"].'</td>
        </tr>';
        if ($i == $data->num_rows - 1) {
            setcookie("rem_amount",$row[$i]["wall_money"],time()+(86400*30),"/");
        }
    }}
    else{
        for ($i=$data->num_rows-10; $i < $data->num_rows ; $i++) { 
            echo ' <tr>
            <td>'.$row[$i]["entryid"].'</td>
            <td>'.$row[$i]["date"].'</td>
            <td>'.$row[$i]["spent"].'</td>
            <td>'.$row[$i]["added"].'</td>
             <td>'.$row[$i]["desc"].'</td>
             <td>'.$row[$i]["wall_money"].'</td>
             </tr>';
         }
    }
    ?>
    </table>
    </fieldset>
  </div>

    <div class="summ">
    <fieldset>
    <legend>Summery</legend>
    Avarage Adding Amount : 
    <?php 
    $ave_add = 0;
    if($data->num_rows >10)
    {
      for ($i =$data->num_rows-10; $i < $data->num_rows ; $i++) { 
        $ave_add = $ave_add + $row[$i]["added"];
    }
    $ave_add = $ave_spend / 10;
    echo $ave_add." Rs. ";
    }
    else{
      for ($i =1; $i < $data->num_rows ; $i++) { 
        $ave_add = $ave_add + $row[$i]["added"];
    }
    $ave_add = $ave_add / ($data->num_rows - 1);
    echo $ave_add." Rs. ";
    }
    ?>
  <br>
  Avarage spending Amount : 
    <?php 
    $ave_spend = 0;
    if($data->num_rows >10)
    {
      for ($i =$data->num_rows-10; $i < $data->num_rows ; $i++) { 
        $ave_spend = $ave_spend + $row[$i]["spent"];
    }
    $ave_spend = $ave_spend / 10;
    echo $ave_spend." Rs. ";
    }
    else{
      for ($i =1; $i < $data->num_rows ; $i++) { 
        $ave_spend = $ave_spend + $row[$i]["spent"];
    }
    $ave_spend = $ave_spend / ($data->num_rows-1);
    echo $ave_spend." Rs. ";
    }
    
    ?>

  <br><br>
  <?php
    if ($ave_spend > $ave_add) {
      echo "You have to save more ....!";
    }
  ?>
  
    </fieldset>
    </div>
    
    <div class="logout">
    <a  href="?logoutreq=tr" class="btn btn-secondary" >Log out</a>
    </div>
    
    <div class="footer row">
      <div class="col-md-6">
        copyrights@ShivangiOrnakaer <br>
        contect us:<br>
        E-mail :  ornakershivangi@gmail.com<br>
        Call : 9727688976<br>
        <h4><b>Thank You</b></h4>
      </div>
      <div class="col-md-6">
        devloped by <br>
        <i>shivangi ornakar</i> <br>
        open for everyone to devlope
        <h2><b>WalletManager<b></h2>

      </div>
    </div>







    <!--log out process -->
    <?php
        function logout(){
            echo "function called";
            unset($_COOKIE['current_user']);
            setcookie("current_user",null,-1,'/');
            unset($_COOKIE['current_id']);
            setcookie("current_id",null,-1,'/');
            unset($_COOKIE['rem_amount']);
            setcookie("rem_amount",null,-1,'/');
            header("location:./index.php");
            return true;
        }
        if($_GET['logoutreq']=="tr"){
            logout();
        }
    ?>


<!-- Modals -->
<!-- add-money-modals -->
<div class="modal fade" id="add-money-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form action="?addclick=tr" method="post" name="addingform">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Added Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <input class="amount" type="number" name="add-amount-entry" placeholder="Enter the amount you spent" required><br>
        <textarea class="des" name="add-desc-entry" placeholder="Enter the description (max 100 letters)" cols="40" rows="4"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input class="btn btn-primary" type="submit" value="done">
      </div>
    </form>
    </div>
  </div>
</div>

<!--add modal php-->
<?php
    if ($_GET['addclick']=='tr') {
        $result=add_entry(connection(),$_COOKIE['current_user'],$_POST['add-amount-entry'],$_POST["add-desc-entry"]);
        if ($result) {
            header('location:./home.php'); 
        }
    }
?>

<!-- spent-money-modals -->
<div class="modal fade" id="spent-money-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form action="?spentclick=tr" method="post">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Spent Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input class="amount" type="number" name="spent-amount-entry" placeholder="Enter the amount you spent" required><br>
        <textarea class="des" name="spent-desc-entry" placeholder="Enter the description (max 100 letters)" cols="40" rows="4"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input class="btn btn-primary" type="submit" value="Done">
      </div>
    </form>
    </div>
  </div>
</div>
<!--spent modal php-->
<?php
    if ($_GET['spentclick']=='tr') {
        $result=spent_entry(connection(),$_COOKIE['current_user'],$_POST['spent-amount-entry'],$_POST["spent-desc-entry"]);
        if ($result) {
            header('location:./home.php'); 
        }
    }
?>



</div>



<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>