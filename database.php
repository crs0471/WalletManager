
<?php

ob_start();

function connection(){
    
    $con = new mysqli("localhost","root","","wm");
    if($con->conect_error){
        echo "<br>error : ".$con->connect_error;
    }
    else{
        $_SESSION['connected'] = True;
        #echo "<br>connected to dataabase";
        return $con;
    }
}
# functions

function insert_user($con,$username){
    
    $sql = "INSERT INTO users(username) VALUES('" .$username.  "')";
    if ($con->query($sql) === TRUE) {
        echo "<br>inserted";
        $sql = "CREATE TABLE `wm`.`$username` ( `entryid` INT(6) NOT NULL AUTO_INCREMENT , `date` DATE NULL , `spent` INT(6) NULL , `added` INT(6) NULL , `desc` VARCHAR(100) NULL , `wall_money` INT(10) NULL , PRIMARY KEY (`entryid`)) ENGINE = InnoDB;";
        $con->query($sql);
        #echo var_dump($con->query($sql));
        #echo "table created";
        
        return True;
    }
    else{
        echo "<br>error : ";
        return False;
    }
}

function start_entry($con,$username,$total_money){
    $c_date = date("Y-m-d");
    echo "<br>$c_date";
    $sql = "INSERT INTO ".$username." VALUES (NULL, '$c_date', '0',$total_money, 'This is starting money.', '$total_money')";
    $con->query($sql);
    #echo var_dump($con->query($sql));
    #echo "inserted";
    validate_username($con,$username);
}

function validate_username($con,$username){

    $sql = "SELECT * from users WHERE username = '" .$username. "'";
    $out = $con->query($sql);
    #echo "<br>selected :";
    #echo var_dump($out);
    #echo "<br>num_rows : " .$out->num_rows;
    if ($out->num_rows == 1) {
        #echo "<br>the fetched data is : <br>";
        $row = $out->fetch_assoc();
        #echo "username = " .$row["username"] . "    ,userid = ".$row["userid"];
        setcookie("current_user",$row["username"],time()+(86400*30),"/");
        setcookie("current_id",$row["userid"],time()+(86400*30),"/");
        
        header("location:./home.php");
        return True;
    }
    else
    {
        return False;   
    }
}


function fetchdata($con,$username){
    $sql = "SELECT * FROM ".$username ;
    $data = $con->query($sql);
    /*$row = $data->fetch_all(MYSQLI_ASSOC);;
    echo "<br>------<br>";
    echo var_dump($row);
    echo "<br>------<br>";
    echo var_dump($data);
    echo "<br>";
    echo "--data--<br>";
    for ($i=0; $i < $data->num_rows ; $i++) { 
        echo $row[$i]['entryid'];
        echo " || ";
        echo $row[$i]['date'];
        echo " || ";
        echo $row[$i]['spend'];
        echo " || ";
        echo $row[$i]['added'];
        echo " || ";
        echo $row[$i]['dec'];
        echo " || ";
        echo $row[$i]['wall_money'];
        echo "<br>----------<br>";  
    }*/
    return $data;    
        
    }
    

    function spent_entry($con,$username,$amount,$desc){
        $c_date = date("Y-m-d");
        $final = intval($_COOKIE['rem_amount']);
        $final = $final - $amount;
        $sql = "INSERT INTO ".$username." VALUES (NULL, '$c_date', '$amount','0', '$desc',$final)";
        $con->query($sql);
        return True;
    }

    function add_entry($con,$username,$amount,$desc){
        $c_date = date("Y-m-d");
        $final = intval($_COOKIE['rem_amount']);
        $final = $final + $amount;
        $sql = "INSERT INTO ".$username." VALUES (NULL, '$c_date','0', '$amount', '$desc',$final)";
        $con->query($sql);
        return True;
    }



?>




