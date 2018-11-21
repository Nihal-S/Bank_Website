<?php
  // create 3 databases
  // 1. MAN_Bank_logs
  // 2. MAN_Bank_close
  // 3. MAN_Bank_transaction

   $dbhost = 'localhost:3306';
   $dbuser = 'root';
   $dbpass = '';
   $dbname = 'MAN_Bank_logs';
   $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
   $dbname2 = 'MAN_Bank_close';
   $conn2 = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname2);
    
    $create_db1 = "CREATE TABLE MAN_bank_logs(
    USN VARCHAR(30) NOT NULL PRIMARY KEY,
    EMAIL VARCHAR(30),
    PHONE VARCHAR(20),
    ADDR VARCHAR(100),
    PASS VARCHAR(16),
    AMOUNT INT(7)
    )";
    mysqli_query($conn,$create_db1);

    $create_db2 = "CREATE TABLE MAN_Bank_close(
    USN VARCHAR(30),
    REASON VARCHAR(2)
    )";
    mysqli_query($conn2,$create_db2);





?>