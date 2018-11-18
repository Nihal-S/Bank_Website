  <?php
   $dbhost = 'localhost:3306';
   $dbuser = 'root';
   $dbpass = '';
   $dbname = 'MAN_Bank_logs';
   $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
   
    
    $sql_user = "CREATE TABLE MAN_bank_logs(
    USN VARCHAR(30) NOT NULL PRIMARY KEY,
    EMAIL VARCHAR(30),
    PHONE VARCHAR(20),
    ADDR VARCHAR(100),
    PASS VARCHAR(16),
    AMOUNT INT(7)
    )";

    mysqli_query($conn,$sql_user);
?>