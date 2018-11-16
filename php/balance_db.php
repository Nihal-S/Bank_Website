<?php
   $dbhost = 'localhost:3306';
   $dbuser = 'root';
   $dbpass = '';
   $dbname = 'MAN_Bank_logs';
   $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
   
   if(! $conn ) {
      die('Could not connect: ' . mysqli_connect_error());
   }
   
   echo 'Please Wait.. Connecting to MAN Bank Database</br>';
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $usn = $_POST['usn'];
	$pwd = $_POST['pwd'];
}

$select = "SELECT * FROM MAN_Bank_logs";
$result = mysqli_query( $conn,$select );
 echo "<table border='collapse'>"; 
        echo "<tr>"; 
        echo "<th>USN</th>"; 
        echo "<th>EMAIL</th>"; 
        echo "<th>PHONE</th>"; 
		echo "<th>AMOUNT</th>";
        echo "</tr>";
while($row = mysqli_fetch_array($result)) 
{
   if($usn==$row['USN'])
   {
       if($pwd==$row['PASSWORD'])
       {
        echo "<tr>"; 
        echo "<td>".$row['USN']."</td>"; 
        echo "<td>".$row['EMAIL']."</td>"; 
        echo "<td>".$row['PHONE']."</td>"; 
		echo "<td>".$row['AMOUNT']."</td>"; 
        echo "</tr>";
        echo "</table>";
        break;
        } 			
        elseif(($pwd=!$row['PASSWORD'])
        {
            echo "Password donot match";
            echo "<a href="about.html">Forgot Password</a>";
            break;
        }
    }    
}

mysqli_close($conn);
?>