<?php
   $dbhost = 'localhost:3306';
   $dbuser = 'root';
   $dbpass = '';
   $dbname = 'MAN_Bank_logs';
   $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
   
   if(! $conn ) {
      die('Could not connect: ' . mysqli_connect_error());
   }
   
   echo 'Connected successfully</br>';
   
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $USN = $_POST['usn'];
    $EMAIL = $_POST['email'];
    $PHONE = $_POST['phno'];
	$ADDR = $_POST['addr'];
    $PWD = $_POST['pwd'];
	$AMOUNT = $_POST['dep'];
    } 
    
//    $sql_user = "CREATE TABLE MAN_bank_logs(
//     USN VARCHAR(30) NOT NULL,
//     EMAIL VARCHAR(30),
//     PHONE INT(10),
//     ADDR VARCHAR(100),
//     PASS VARCHAR(16),
//     AMOUNT INT(7)
//     )";

//     mysqli_query($conn,$sql_user);

    $sql = "INSERT INTO MAN_bank_logs(USN,EMAIL,PHONE,ADDR, PASS, AMOUNT)
    VALUES ('$USN','$EMAIL',$PHONE,'$ADDR','$PWD',$AMOUNT )";
    
    $result = mysqli_query( $conn,$sql);
    echo "$result";
    if(!$result)
    {
            echo "error</br>".mysqli_connect_error();
    }

    mysqli_close($conn);
    ?>