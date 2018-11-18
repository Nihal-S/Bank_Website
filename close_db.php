<!DOCTYPE html>
<html lang="en">
<head>
    <link href="style_php.css" rel="stylesheet" type="text/css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MAN Bank</title>
</head>
<body>  
<div id="navigation">
                <ul>
                    <li><a href="Index.html">Home</a></li>
                    <li><a href="create.html">New Account</a></li>
                    <li><a href="balance.html">Balance</a></li>
                    <li><a href="deposit.html">Deposit</a></li>
                    <li><a href="withdraw.html">Withdraw</a></li>
                    <li><a href="transfer.html">Transfer</a></li>
                    <li><a href="about.html">Contact</a></li>
                    <li><a href="faq.html">FAQ's</a></li>
                </ul>
        </div>
<?php
   $dbhost = 'localhost:3306';
   $dbuser = 'root';
   $dbpass = '';
   $dbname = 'MAN_Bank_logs';
   $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
   $dbname2= 'MAN_Bank_transaction';
   $conn2 = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname2);
   $dbname3 = 'MAN_Bank_close';
   $conn3 = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname3);
   if(! $conn ) {
    die('Could not connect: ' . mysqli_connect_error());
   } 
   $forward=0;
   if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
    // collect value of input field
	$USN = $_POST['usn'];
    $PWD= $_POST['pwd'];
    $REASON = $_POST['reason'];
    }
    // echo "$REASON";
//     $select= "SELECT * FROM MAN_Bank_logs";
// $result = mysqli_query( $conn,$select );
// $exist=0;
// while($row = mysqli_fetch_array($result))
//     if(($usn==$row['USN'])) $exist=1;

   $select = "SELECT * FROM MAN_Bank_logs";
   $result = mysqli_query( $conn,$select );
   while($row = mysqli_fetch_array($result))
   {
       if(($USN==$row['USN']) && (($PWD==$row['PASS'])))
       {
          $sql_del="DELETE from MAN_Bank_logs where USN = '$USN'";
          mysqli_query( $conn,$sql_del);
          
          $sql_reason = "INSERT INTO MAN_Bank_close(USN, REASON) VALUES('$USN','$REASON')";
          mysqli_query( $conn3,$sql_reason);
       
          $drop = "DROP TABLE $USN";
          mysqli_query( $conn2,$drop );
       
          $forward=1;
          break;  
       }
       elseif(($USN==$row['USN'])&&($PWD!=$row['PASS']))
       {
        echo "<h2 id='php_p'>Wrong Password<br><br><br><br><br><br><br><br><br><br></h2>";
        $forward=0;
        break;
        }   
   
}

if($forward)
echo"<h2 id='php_p'> ACCOUNT CLOSED</h2><br><br><br><br><br><br><br><br>";



mysqli_close($conn);
?>
<br><br><br><br><br><br><br><br><br><br>
    <div id="footer_top">
        <div id="footer_navigation">
        <p>IMPORTANT : MAN Bank never asks for your user id/password/pin no. through phone call/SMSes/e-mails. Please do not respond to any such phone call/SMSes/e-mails. Any such phone calls/SMSes/E-mails asking you to reveal your login credentials or One Time Password through SMS could be an attempt to withdraw money from your account. NEVER NEVER share these details to anyone.</p><br><br><br>                     
            <h6 align="center">Copyright © MAN Bank Inc 2018 </h6>    </div>
</body>
</html>