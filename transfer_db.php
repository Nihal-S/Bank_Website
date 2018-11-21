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
   
//    echo 'Please Wait.. Connecting to MAN Bank Database</br>';
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $usn = $_POST['usn'];
    $pwd = $_POST['pwd'];
    $amt = $_POST['dep'];
    $c_amt=$_POST['c_dep'];
    $to_usn=$_POST['to_usn'];
}

$select = "SELECT * FROM MAN_Bank_logs";
$result = mysqli_query( $conn,$select );
while($row = mysqli_fetch_array($result))
if($to_usn==$row['USN']) break;
if($to_usn==$row['USN']){
$select = "SELECT * FROM MAN_Bank_logs";
$result = mysqli_query( $conn,$select );
while($row = mysqli_fetch_array($result))
if($usn==$row['USN']) break;
if($pwd==$row['PASS'])
{

$select= "SELECT * FROM MAN_Bank_logs";
$result = mysqli_query( $conn,$select );
$exist=0;
while($row = mysqli_fetch_array($result))
    if(($usn==$row['USN'])) $exist=1;
    if(($amt == $c_amt)&&($exist)){
        $select= "SELECT * FROM MAN_Bank_logs";
        $result = mysqli_query( $conn,$select );
        while($row = mysqli_fetch_array($result)){
            if(($usn==$row['USN'])&&($pwd==$row['PASS']))
            {                
            $from_amt_update = $row['AMOUNT'] - $amt;
            if($from_amt_update>=0){
            $from_update= "UPDATE MAN_Bank_logs SET AMOUNT = $from_amt_update where USN='$usn'";
            mysqli_query( $conn,$from_update);
            $forward=1;
            break;
            }
            else{
                echo "<p ><br><br>";
                echo "<h3>Balance not Available</h3>";
                echo "<br><br><br><br><br><br><br><br><br><br></p>";
                $forward=0;
                break;
            }
            }
            }    // UPDATE MAN_Bank_logs SET AMOUNT=AMOUNT-$amt;
            $select= "SELECT * FROM MAN_Bank_logs";
            $result = mysqli_query( $conn,$select );    
            while($row = mysqli_fetch_array($result)){
            if(($to_usn==$row['USN']))
            {   
                $to_amt_update = $row['AMOUNT'] + $amt;
                $to_update = "UPDATE MAN_Bank_logs SET AMOUNT=$to_amt_update where USN = '$to_usn'";
                mysqli_query( $conn,$to_update);
                break;
            }
        }
    

    if($forward)
     {
        $select= "SELECT * FROM MAN_Bank_logs";
        $result = mysqli_query( $conn,$select );
        while($row = mysqli_fetch_array($result)){
            if(($usn==$row['USN'])&&($pwd==$row['PASS']))
            {                
            // echo "Available Balance";
            echo "<br><br><div><table id='php_table' border='collapse'>"; 
            echo "<tr>"; 
            echo "<td>USN</td>"; 
            echo "<td>EMAIL</td>"; 
            echo "<td>PHONE</td>"; 
	    	echo "<td>AVAILABLE BALANCE</td>";
            echo "</tr>";
            echo "<tr>"; 
            echo "<td>".$row['USN']."</td>"; 
            echo "<td>".$row['EMAIL']."</td>"; 
            echo "<td>".$row['PHONE']."</td>"; 
            echo "<td>".$row['AMOUNT']."</td>"; 
            echo "</tr>";
            echo "</table></div><br><br>";
            }}


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
            passbook($usn,"TRANSFERRED to $to_usn",$from_amt_update,$conn2);


            function passdisp($usn,$conn2)
    {
        // $select= "SELECT * FROM $usn";
        // $result = mysqli_query( $conn2,$select );
        echo "<br><br><div><table id='php_table' border='collapse'>"; 
        echo "<tr>"; 
        echo "<td>Transaction ID</td>"; 
        echo "<td>Type</td>"; 
        echo "<td>Balance</td>"; 
        // echo "<td>AMOUNT</td>";
        echo "</tr>";

        $select= "SELECT * FROM $usn";
        $result = mysqli_query( $conn2,$select );
        while($row = mysqli_fetch_array($result))
        {
            if($row['TID']=='2018001'){
        echo "<tr>";  
        echo "<td>".$usn."_".$row['TID']."</td>"; 
        echo "<td>".$row['T_TYPE']."</td>"; 
        echo "<td>".$row['AMT']."</td>"; 
        echo "</tr>";
            }
        }

        $select= "SELECT * FROM $usn";
        $result = mysqli_query( $conn2,$select );
        while($row = mysqli_fetch_array($result))
        {
            if($row['TID']!='2018001'){
        echo "<tr>";  
        echo "<td>".$usn."_".$row['TID']."</td>"; 
        echo "<td>".$row['T_TYPE']."</td>"; 
        echo "<td>".$row['AMT']."</td>"; 
        echo "</tr>";
            }
        }
        echo "</table></div>";
    }
    passdisp($usn,$conn2);
    }
    if(!$exist) echo "<br><br><h3>$usn Doesnot Exist</h3>";


    }
    else
echo "<br><br><h3>Transfer Amount donot match.</h3><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";





}
else
echo "<br><br><h3>Username and Password donot match</h3><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
}
else
echo "<br><br><h3>To Username doesnot exists.</h3><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";


mysqli_close($conn);
?>
<br><br><br><br>
        <div id="footer_top">
            <div id="footer_navigation">
                    <p>IMPORTANT : MAN Bank never asks for your user id/password/pin no. through phone call/SMSes/e-mails. Please do not respond to any such phone call/SMSes/e-mails. Any such phone calls/SMSes/E-mails asking you to reveal your login credentials or One Time Password through SMS could be an attempt to withdraw money from your account. NEVER NEVER share these details to anyone.</p><br><br><br>                     
                <h6 align="center">Copyright © MAN Bank Inc 2018 </h6>    </div>
</body>
</html>