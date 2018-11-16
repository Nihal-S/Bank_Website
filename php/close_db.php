<?php
   $dbhost = 'localhost:3306';
   $dbuser = 'root';
   $dbpass = '';
   $dbname = 'MAN_Bank_logs';
   $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);

   if(! $conn ) {
    die('Could not connect: ' . mysqli_connect_error());
   } 

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
	$USN1 = $_POST['usn'];
    $PWD1= $_POST['pwd'];
    $REASON = $_POST['reason'];
   }
   $select = "SELECT * FROM MAN_Bank_logs where MAN_Bank_logs(USN)=$USN1";
   
   $row = mysqli_fetch_array(mysqli_query( $conn,$select ));
   echo "$row";
//    {
       if($USN1==$row['USN'])
       {
           if($PWD1==$row['PASS'])
           {
              $sql_del ="DELETE $row from MAN_Bank_logs";
              mysqli_query($conn,$sql_del);
            //    break;
           }
       }
//    }
   $sql_user = "CREATE TABLE MAN_bank_close(
           USN VARCHAR(30) NOT NULL,
            REASON VARCHAR2(100))";
   mysqli_query($conn,$sql_user);
  $sql="INSERT INTO MAN_Bank_close(USN, REASON) VALUES('$USN1','$REASON')";
   mysqli_query($conn,$sql);
   mysqli_close($conn);
 ?>