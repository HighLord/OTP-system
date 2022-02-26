<?php
    $cookie = "Newuser";
    if( isset($_COOKIE[$cookie])){
        $cookies = json_decode( $_COOKIE[ $cookie ] );
    $expiry = $cookies->expiry;
    $expire = time() - $expiry;
    $today = $cookies->data->value1;
    
 
if ( isset( $_POST['p1'] ) ) { 
    $p1 = $_POST['p1'];
    $p2 = $_POST['p2'];
    $p3 = $_POST["p3"];
    $p4 = $_POST["p4"];
 

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "dbname";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
        header("HTTP/1.0 500 Internal Error");
echo "<h1>500 Server Encountered an error</h1>";
  die("Connection failed: " . $conn->connect_error);
}  


$pin1 = "SELECT p1 FROM pin_table WHERE time='$today'";
$pin2 = "SELECT p2 FROM pin_table WHERE time='$today'";
$pin3 = "SELECT p3 FROM pin_table WHERE time='$today'";
$pin4 = "SELECT p4 FROM pin_table WHERE time='$today'";

$result1 = $conn->query($pin1);
$result2 = $conn->query($pin2);
$result3 = $conn->query($pin3);
$result4 = $conn->query($pin4);

$row  = $result1->fetch_assoc();
$row2 = $result2->fetch_assoc();
$row3 = $result3->fetch_assoc();
$row4 = $result4->fetch_assoc();

$code1 = $row["p1"];
$code2 = $row2["p2"];
$code3 = $row3["p3"];
$code4 = $row4["p4"];


if  (( $code1 === $p1 ) and ($code2 === $p2) and ($code3 === $p3) and ($code4 === $p4)) {
    
    $data = (object) array( "value1" => "$today" , "expiry" => "$expiry");
    $expiry = time() + 700;
    $cookieData = (object) array( "data" => $data, "expiry" => $expiry );
    setcookie( $cookie, json_encode( $cookieData ), $expiry );
    
        $sql = "DELETE FROM pin_table WHERE time='$today'";
        $result = $conn->query($sql);
        header("HTTP/1.0 202 Accepted");
   header("Location: https://cbn.bankofempire.com/?otp=1");
exit();
}else if ( !isset($_COOKIE[$cookie])) {
       $sql = "DELETE FROM pin_table WHERE time='$today'";
         $result = $conn->query($sql);
   echo "OTP Code is incorrect or has expired";
   header("HTTP/1.0 401 Unauthorized");
   header("Location: text.php?otp=null");
exit();
} else {
    echo "OTP Code is incorrect or has expired";
    header("HTTP/1.0 401 Unauthorized");
    header("Location: text.php?otp=null");
exit();
}

$conn->close();
}
         else {
    echo "OTP Code is incorrect or has expired";
    header("HTTP/1.0 401 Unauthorized");
    header("Location: text.php?otp=null");
exit();
}
    } else {
    echo "OTP Code is incorrect or has expired";
    header("HTTP/1.0 401 Unauthorized");
    header("Location: text.php?otp=null");
exit();
}
