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
                    <li><a href="Index.html"> Home</a></li>
                    <li><a href="create.html">New Account</a></li>
                    <li><a href="balance.html">Balance</a></li>
                    <li><a href="deposit.html">Deposit</a></li>
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
   $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
   $dbname2 = 'MAN_Bank_transaction';
   $conn2 = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname2);
   
   if(! $conn ) {
      die('Could not connect: ' . mysqli_connect_error());
   }
   
//    echo 'Please Wait.. <br><br>Connecting to MAN Bank Database<br><br>';
   
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $usn = $_POST['usn'];
    $pwd = $_POST['pwd'];
    $amt = $_POST['dep'];
    $c_amt=$_POST['c_dep'];
}

$select= "SELECT * FROM MAN_Bank_logs";
$result = mysqli_query( $conn,$select );
$exist=0;
while($row = mysqli_fetch_array($result))
    if(($usn==$row['USN'])) $exist=1;
    $func_amt=0;
    if(($amt == $c_amt)&&($exist)){
    $select= "SELECT * FROM MAN_Bank_logs";
    $result = mysqli_query( $conn,$select );
    while($row = mysqli_fetch_array($result))
    {
        if(($usn == $row['USN'])&&($pwd==$row['PASS']))
        {
            $amt_update = $row['AMOUNT'] - $amt;
            $func_amt=$amt_update;
            if($amt_update>=0){
            $withdraw_update= "UPDATE MAN_Bank_logs SET AMOUNT = $amt_update where USN='$usn'";
            mysqli_query( $conn,$withdraw_update);
            $forward=1;
            break;
        }
            
        else{
                echo "<p ><br><br>";
                echo "<h2 id='php_p'>Balance not Available</h2>";
                echo "<br><br><br><br><br><br><br><br><br><br></p>";
                $forward=0;
            }}
    elseif(($usn==$row['USN'])&&($pwd!=$row['PASS']))
                {
                echo "<p ><br><br>";
                echo "<h2 id='php_p'>Wrong Password</h2>";
                echo "<br><br><br><br><br><br><br><br><br><br></p>";
                break;
                }
        }

        $select= "SELECT * FROM MAN_Bank_logs";
        $result = mysqli_query( $conn,$select );
        while($row = mysqli_fetch_array($result))
        {
            if(($usn == $row['USN'])&&($pwd==$row['PASS'])&&($forward))
            {
            // echo "Available Balance";
            echo "<br><br> <br><br><table  id='php_table' border='collapse'>"; 
            echo "<tr>"; 
            echo "<td>USN</td>"; 
            echo "<td>EMAIL</td>"; 
            echo "<td>PHONE</td>"; 
	    	echo "<td>AMOUNT</td>";
            echo "</tr>";
            echo "<tr>"; 
            echo "<td>".$row['USN']."</td>"; 
            echo "<td>".$row['EMAIL']."</td>"; 
            echo "<td>".$row['PHONE']."</td>"; 
            echo "<td>".$row['AMOUNT']."</td>"; 
            echo "</tr>";
            echo "</table></div><br><br>";
            break;
            }
    }

    function passbook($usn,$type,$amt,$conn2)
            {
            
                // $sql_pass= "CREATE TABLE $usn(
                //     TID INT(10) NOT NULL AUTO_INCREMENT,
                //     T_TYPE VARCHAR(100),
                //     AMT INT(7))
                //     ";
                // mysqli_query( $conn2, $sql_pass);
            
                $select= "SELECT * FROM $usn";
                $result = mysqli_query( $conn2,$select );
                $i=0;
                while($row = mysqli_fetch_array($result)) $i++;
                $i=2017001 + $i;
                    
                $sql_pass2 = "INSERT INTO $usn(TID,T_TYPE,AMT) VALUES('$i','$type','$amt')";
                mysqli_query( $conn2, $sql_pass2);
    
            }
           if($forward) passbook($usn,"DEBIT",$func_amt,$conn2);
        function passdisp($usn,$conn2)
        {
            $select= "SELECT * FROM $usn";
            $result = mysqli_query( $conn2,$select );
            echo '<br><br> <br><br><table  id="php_table"  border="collapse">';
            echo "<tr>"; 
            echo "<td>Transaction ID</td>"; 
            echo "<td>Type</td>"; 
            echo "<td>Balance</td>"; 
	    	// echo "<td>AMOUNT</td>";
            echo "</tr>";



            while($row = mysqli_fetch_array($result))
            {
            echo "<tr>";  
            echo "<td>".$usn."_".$row['TID']."</td>"; 
            echo "<td>".$row['T_TYPE']."</td>"; 
            echo "<td>".$row['AMT']."</td>"; 
            echo "</tr>";

            }
            echo "</table></div>";
        }
        if($forward) passdisp($usn,$conn2);
    }
    if(!$exist)
echo "<br><br><h1 id='php_p'>$usn Doesnot Exist</h1>";




mysqli_close($conn);
?>
<br><br><br><br>
        <div id="footer_top">
            <div id="footer_navigation">
                    <p>IMPORTANT : MAN Bank never asks for your user id/password/pin no. through phone call/SMSes/e-mails. Please do not respond to any such phone call/SMSes/e-mails. Any such phone calls/SMSes/E-mails asking you to reveal your login credentials or One Time Password through SMS could be an attempt to withdraw money from your account. NEVER NEVER share these details to anyone.</p><br><br><br>                     
                <h6 align="center">Copyright © MAN Bank Inc 2018 </h6>    </div>
</body>
</html>