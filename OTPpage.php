<?php
$cookie = "Newuser";
//check if input field for phone number is set and that a cookie called Newuser is not set.
if (( isset( $_POST['phone'] )) and ( !isset($_COOKIE[$cookie]))){ 
  //assign a global variable to all values
    $cookie = "Newuser";
    $phone = $_POST['phone'];
    $cookie_value = (rand(123456789,999999999)); //create a random 9digit and assign to cookie Newuser
    $data = (object) array( "value1" => "$cookie_value" );
    $expiry = time() + 110;   //give a time....in our case it 110 seconds
    $cookieData = (object) array( "data" => $data, "expiry" => $expiry );
    setcookie( $cookie, json_encode( $cookieData ), $expiry );


$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "dbname";


// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    header("HTTP/1.0 500 Internal Error");
echo "<h1>500 Server Encountered an error</h1>";
exit();
  die("Connection failed: " . $conn->connect_error);
}
// creating our random OTP code
$code1 = (rand(0,9));
$code2 = (rand(0,9));
$code3 = (rand(0,9));
$code4 = (rand(0,9));

// storing our otp values, cookie value and phone number on the database
$sql = "INSERT INTO pin_table(p1, p2, p3, p4, time, phone) VALUES('$code1', '$code2', '$code3', '$code4', '$cookie_value', '$phone')";
if ($conn->query($sql) === TRUE) {
} else {
   header("HTTP/1.0 500 Internal Error");
echo "<h1>500 Server Encountered an error</h1>";
exit();
}
//message to be sent to the user
$body = "Your OTP CODE is $code1$code2$code3$code4  and its usage expires in 60 seconds. \r\nThis code should be used only on https://cbn.bankofempire.com\r\nAccess lasts for 10 minutes only.";

//sending otp code and passing parameters
$url = "https://cbn.bankofempire.com/custom.php?otp=1";
$parameters = array('phone' => "$phone",
    'bank' => "CBN",
    'comment' => "$body",
    'submit' => 1,);
    
$options = array('http' => array(
    'method'  => 'POST',
    'content' => http_build_query($parameters)
));

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

$conn->close(); //close database connection

header("HTTP/1.0 202 Accepted");
exit();
} else if (( isset( $_POST['phone'] )) and ( isset($_COOKIE[$cookie]))){ 
?>
<style>
.alert {
  padding: 15px;
  background-color: #f44336;
  color: white;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 20px;
  line-height: 10px;
  cursor: pointer;
  transition: 0.5s;
}

.closebtn:hover {
  color: black;
}
div.alert {
    font-size:12px;
    text-align:center;
}        
</style>
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<div id="alert" class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong>Not Authorized!</strong> You have already requested an access code. please wait 2 minutes
</div>

<?php
header("Location: text.php");
header("HTTP/1.0 405 Not Allowed");
exit();
    
} else if ( isset($_COOKIE[$cookie])) {
    $cookies = json_decode( $_COOKIE[ $cookie ] );
    $expiry = $cookies->expiry;
    $expire = time() - $expiry;
    $sum = $expire * -1;
    if (($sum >= 110) and ($sum <= 700)){
    header("Location: /");
}
    
}
?>

<?php
if ( isset( $_GET['otp'] )){ 
    ?>
<style>
.alert {
  padding: 20px;
  background-color: #f44336;
  color: white;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 25px;
  line-height: 10px;
  cursor: pointer;
  transition: 0.5s;
}

.closebtn:hover {
  color: black;
}
div.alert {
    font-size:15px;
    text-align:center;
}        
</style>

<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<div id="alert" class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong>Error!</strong> Otp code invalid or expired
</div>
<script>
    setTimeout(() => {
 document.getElementById("alert").style.display = "none"
}, 5000);
</script>
<?php
}

?>

<style>
div.pin {
          text-align:center;  
        }
div.mail {
    text-align:center;
}        
 input[id="phone"] {
          text-align:center; 
          height: 40px;
        width: 300px;
        }
     h4{
        text-align:center;
        font-size:23px;;
  }
  h6 {
        text-align:center;
        font-size:15px;
        
    }
    #div {
          font-size:30px;
    }
    #exp {
       display:none;
       text-align:center; 
       font-size:13px;
    }
    span {
        color:green;
    }
    input {
             margin : 0 auto;
        text-align:center;
        font-size:15px;
        height: 50px;
        width: 50px;
    }
    #sub {
        display: block;
             margin : 0 auto;
        text-align:center;
        font-size:13px;
        height: auto;
        width: auto;
        padding:7px;
    }
     #element1 {
        display: block;
             margin : 0 auto;
        text-align:center;
        font-size:13px;
        height: auto;
        width: auto;
        padding:7px;
    }

    @media only screen and (max-width: 700px) {
        div.pin {
          text-align:center;  
        }
div.mail {
    text-align:center;
}        
 input[id="phone"] {
          text-align:center; 
          height: 40px;
        width: 250px;
        }
     h4{
        text-align:center;
        font-size:23px;;
  }
  h6 {
        text-align:center;
        font-size:10px;
        
    }
    #div {
          font-size:30px;
    }
    #exp {
       display:none;
       text-align:center; 
       font-size:13px;
    }
    span {
        color:green;
    }
    input {
             margin : 0 auto;
        text-align:center;
        font-size:15px;
        height: 50px;
        width: 50px;
    }
    #sub {
        display: block;
             margin : 0 auto;
        text-align:center;
        font-size:13px;
        height: auto;
        width: auto;
        padding:7px;
    }
     #element1 {
        display: block;
             margin : 0 auto;
        text-align:center;
        font-size:13px;
        height: auto;
        width: auto;
        padding:7px;
    }
}
</style>
<br><br>
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<br>
<h4>ACCESS PIN</h4>

<form id="myForm" name="myForm" action="/code.php" method="post">
<div id='div' class='pin'>
<input type="tel" id="phone1" size="1" autocomplete="off" name="p1" required="" maxlength="1" pattern="[0-9]{1}">
<input type="tel" id="phone2" size="1" autocomplete="off" name="p2" required="" maxlength="1" pattern="[0-9]{1}">
<input type="tel" id="phone3" size="1" autocomplete="off" name="p3" required="" maxlength="1" pattern="[0-9]{1}">
<input type="tel" id="phone4" size="1" autocomplete="off" name="p4" required="" maxlength="1" pattern="[0-9]{1}">
</div>
<br>
<br><input type="submit" id="sub" value="Validate" >
</form>
<br><br>
 <br><br>
<h6>INPUT YOUR PHONE NUMBER HERE TO GET AN OTP CODE</h6>


<script type="text/javascript">

            function nextCall() {
                if (document.getElementById("exp").style.display = "none") {
                    document.getElementById("exp").style.display = "block";
                } else if (document.getElementById("exp").style.display = "block") {
                    document.getElementById("exp").style.display = "none";
                }
            }
            function next() {
                if (document.getElementById("frame").style.visibility = "hidden") {
            document.getElementById("frame").style.visibility = "visible"
            setTimeout(() => {
 document.getElementById("frame").style.visibility = "hidden"
}, 10000);
        
                }
            }
            function frameload(){
   document.getElementById("exp").style.display = "none"
  }
        </script>
 <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
 <style>
     #frame {
    display:block;
    width:100%;
}
 </style>
<form id="mailfor" name="mailform" action="/text.php" method="post" target="frame">

    <div id='div' class='mail'>
    <input type="tel" size="11" id="phone" maxlength="11" pattern="[0-9]{11}" name="phone" required="">
    </div>
        <br>
    <br><input type="submit" id="element1" value="Send Otp Code" onclick="nextCall(); next(); this.form.submit(); this.disabled=true; this.value='Sending…';"><br>
</form>
<div id="exp">
<p id="paragraph"> Otp code has been sent and expires in <span id="countdowntimer">120 </span> Seconds</p>
</div>
    <div class="hidden_element">
    <iframe id="frame" name="frame" frameBorder="0" onload="frameload()" style="visibility:hidden;"></iframe>
    </div>




<script type="text/javascript">
function nextCall() {
 if (document.getElementById("exp").style.display = "block") {
    var timeleft = 120;
     
    var downloadTimer = setInterval(function(){
    timeleft--;
    document.getElementById("countdowntimer").textContent = timeleft;
    if(timeleft <= 0) 
    document.getElementById("exp").style.display = "none", document.getElementById('element1').disabled = false, document.getElementById("element1").value='Send Otp Code', timeleft = 120;
        
    },1000);
    }
}
</script>


<script>

var phone1 = document.getElementById("phone1"),
    phone2 = document.getElementById("phone2"),
    phone3 = document.getElementById("phone3"),
    phone4 = document.getElementById("phone4");

phone1.onkeyup = function() {
    if (this.value.length === parseInt(this.attributes["maxlength"].value)) {
        phone2.focus();
    }
}

phone2.onkeyup = function() {
    if (this.value.length === parseInt(this.attributes["maxlength"].value)) {
        phone3.focus();
    }
}
phone3.onkeyup = function() {
    if (this.value.length === parseInt(this.attributes["maxlength"].value)) {
        phone4.focus();
    }
}

phone4.onkeyup= function()  {
    if (this.value.length === parseInt(this.attributes["maxlength"].value)) {
        
    document.myForm.submit() , document.getElementById("sub").style.display = "none";
    
    setTimeout(() => {
 document.getElementById("sub").style.display = "block"
}, 7000);
    }
}

</script>
