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
                    <li><a href="balance.html">Balance</a></li>
                    <li><a href="deposit.html">Deposit</a></li>
                    <li><a href="withdraw.html">Withdraw</a></li>
                    <li><a href="transfer.html">Transfer</a></li>
                    <li><a href="close.html">Close A/C</a></li>
                    <li><a href="about.html">Contact</a></li>
                    <li><a href="faq.html">FAQ's</a></li>
                </ul>
        </div>
        
        <?php
   $dbhost = 'localhost:3306';
   $dbuser = 'root';
   $dbpass = '';
   $dbname = 'MAN_Bank_logs';
   $dbname2= 'MAN_Bank_transaction';
   $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
   $conn2 = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname2);
   
   if(! $conn ) {
      die('Could not connect: ' . mysqli_connect_error());
   }
   
//    echo 'Connected successfully</br>';
   
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $USN = $_POST['usn'];
    $EMAIL = $_POST['email'];
    $PHONE = $_POST['phno'];
	$ADDR = $_POST['addr'];
    $PWD = $_POST['pwd'];
	$AMOUNT = $_POST['dep'];
    } 
    $usn_array = array();

//    $sql_user = "CREATE TABLE MAN_bank_logs(
//     USN VARCHAR(30) NOT NULL PRIMARY KEY,
//     EMAIL VARCHAR(30),
//     PHONE VARCHAR(10),
//     ADDR VARCHAR(100),
//     PASS VARCHAR(16),
//     AMOUNT INT(7)
//     )";

//     mysqli_query($conn,$sql_user);




$select= "SELECT * FROM MAN_Bank_logs";
$result = mysqli_query( $conn,$select );
$exist=0;
while($row = mysqli_fetch_array($result))
    if(($USN==$row['USN'])) $exist=1;

if(!$exist){
$type = "OPEN ACCOUNT";
function passbook($usn,$type,$amt,$conn2)
{

    $sql_pass= "CREATE TABLE $usn(
        TID INT(10) NOT NULL primary key,
        T_TYPE VARCHAR(100),
        AMT INT(7))";
    mysqli_query( $conn2, $sql_pass);

    $sql_pass2 = "INSERT INTO $usn(TID,T_TYPE,AMT) VALUES(2018001,'$type','$amt')";
    mysqli_query( $conn2, $sql_pass2);
    

}
passbook($USN,$type, $AMOUNT,$conn2);


    $select= "SELECT * FROM MAN_Bank_logs";
    $result = mysqli_query( $conn,$select );
    while($row = mysqli_fetch_array($result))
    {
    //     $usn_array[$i] = $row['USN'];
    //     $i=$i+1;
        if($USN==$row['USN'])
        {
            echo "<h3>Username Exists. Try another Name<h3><br><br>";
            break;
        }    
    }
    // print_r($usn_array);

    $sql = "INSERT INTO MAN_bank_logs(USN,EMAIL,PHONE,ADDR, PASS, AMOUNT)
    VALUES ('$USN','$EMAIL','$PHONE','$ADDR','$PWD',$AMOUNT )";
    
    $result = mysqli_query( $conn,$sql);
    //echo "$result";
    if(!$result)
    {
            echo "<h3>error<h3></br>".mysqli_connect_error();
    }
    else{
        echo "<h3 align='left'>Account created</h3>";
    }

    function passdisp($usn,$conn2)
    {
        $select2= "SELECT * FROM $usn";
        $result2 = mysqli_query( $conn2,$select2);
        echo "<br><br><div><table id='php_table' border='collapse'>";
        echo "<tr>"; 
        echo "<td>Transaction ID</td>"; 
        echo "<td>Type</td>"; 
        echo "<td>Balance</td>"; 
        // echo "<td>AMOUNT</td>";
        echo "</tr>";
        $select= "SELECT * FROM $usn";
        $result = mysqli_query( $conn2,$select);
        while($row = mysqli_fetch_array($result))
        {
         
        echo "<td>".$usn."_".$row['TID']."</td>"; 
        echo "<td>".$row['T_TYPE']."</td>"; 
        echo "<td>".$row['AMT']."</td>"; 
        echo "</tr>";

        }
        echo "</table></div><br><br><br><br><br><br><br><br><br>";
    }
    passdisp($USN,$conn2);
}
if($exist)  echo "<br><br><h2 id='php_p'>Username Exists. Try another Name</h2><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";




    mysqli_close($conn);
    mysqli_close($conn2);
    ?>
    <br><br><br><br>
        <div id="footer_top">
            <div id="footer_navigation">
                    <p>IMPORTANT : MAN Bank never asks for your user id/password/pin no. through phone call/SMSes/e-mails. Please do not respond to any such phone call/SMSes/e-mails. Any such phone calls/SMSes/E-mails asking you to reveal your login credentials or One Time Password through SMS could be an attempt to withdraw money from your account. NEVER NEVER share these details to anyone.</p><br><br><br>                     
                <h6 align="center">Copyright © MAN Bank Inc 2018 </h6>    </div>
    </body>
    </html>