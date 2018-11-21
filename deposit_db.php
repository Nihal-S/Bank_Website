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
}

$select = "SELECT * FROM MAN_Bank_logs";
$result = mysqli_query( $conn,$select );
while($row = mysqli_fetch_array($result))
if($usn==$row['USN']) break;
if($pwd==$row['PASS'])
{
$amt_update=0;

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
    
    // $sql_pass3 = "UPDATE $usn SET TID=TID+$i";
    // mysqli_query( $conn2, $sql_pass3);
}

$select= "SELECT * FROM MAN_Bank_logs";
$result = mysqli_query( $conn,$select );
$exist=0;
while($row = mysqli_fetch_array($result))
    if(($usn==$row['USN'])) $exist=1;
    $amt_update=0;
    if(($amt == $c_amt)&&($exist)){
    $select= "SELECT * FROM MAN_Bank_logs";
    $result = mysqli_query( $conn,$select );
    while($row = mysqli_fetch_array($result)){
        if(($usn==$row['USN'])&&($pwd==$row['PASS'])){
            $amt_update1 = $row['AMOUNT'] + $amt;
            $sql_update= "UPDATE MAN_Bank_logs SET AMOUNT=$amt_update1";
            $done = mysqli_query( $conn,$sql_update);
            $amt_update=$amt_update1;
            $forward=1;
            break;    
        }
        elseif(($usn==$row['USN'])&&($pwd!=$row['PASS'])){
            echo "Wrong Password";
            $forward=0;
            break;
            }
        }
    
        $select= "SELECT * FROM MAN_Bank_logs";
        $result = mysqli_query( $conn,$select );
        while($row = mysqli_fetch_array($result))
        {
            if(($usn==$row['USN'])&&($pwd==$row['PASS'])&&($forward))
            { 
            // echo "Available Balance";
            echo "<br><br><div><table id='php_table' border='collapse'>"; 
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

        if($forward) passbook($usn,'CREDIT', $amt_update,$conn2);

        function passdisp($usn,$conn2)
    {
        
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
    if($forward) passdisp($usn,$conn2);
    }
    else
    echo "<br><br><h3>Deposit Amount donot match.</h3><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
    if(!$exist)
    echo "<br><br><h3>$usn Doesnot Exist</h3>";
    }
    else
    echo "<br><br><h3>Username and Password donot match</h3><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
    

mysqli_close($conn);
?>
<br><br><br><br>
        <div id="footer_top">
            <div id="footer_navigation">
                    <p>IMPORTANT : MAN Bank never asks for your user id/password/pin no. through phone call/SMSes/e-mails. Please do not respond to any such phone call/SMSes/e-mails. Any such phone calls/SMSes/E-mails asking you to reveal your login credentials or One Time Password through SMS could be an attempt to withdraw money from your account. NEVER NEVER share these details to anyone.</p><br><br><br>                     
                <h6 align="center">Copyright © MAN Bank Inc 2018 </h6>    </div>
</body>
</html>