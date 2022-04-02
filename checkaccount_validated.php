<html>
<body>

<?php

$dbserver = "localhost";
$dbuserid = "insecureapp";
$dbpassword = "45EUlZOpL7";	#1. Hardcoded password
$db = "insecureapp";

$userid = $_POST["userid"];
$password = $_POST["password"];

// Validation
try{
	if(!preg_match("/^[0-9]{3}$/", $userid)){
		throw new Exception("Invalid userid");
	}
	if(!preg_match("/^[0-9]{4}$/", $password)){
		throw new Exception("Invalid password format");
	}
}
catch(Exception $e) {
  die("Error: " . $e->getMessage());

}

echo "<p>userid: " . $userid . "</p>";		#2. Reflected XSS
echo "<p>password: " . $password . "</p>";	#3. Reflected XSS

$conn = new mysqli($dbserver, $dbuserid, $dbpassword, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


// print account details
$sql = "SELECT * FROM users WHERE userid = '" . $userid . "' AND password = '" . $password . "'";	#4. SQL injection
$result = $conn->query($sql);

if ($result->num_rows > 0) {

	// print heading
	echo "<H1>Your Account</H1>";
	echo "<p>Welcome, your account details are:</p>";

	while($row = $result->fetch_assoc()) {
        echo " <p>Name: " . $row["lastname"]. ", " . $row["firstname"]. " <BR>Address: " . $row["address"]. "<br>Phone number: " . $row["phone"] . "</p>";  #5. Stored XSS
    }
}
else
{
echo "<p><b>Login failed</b></p>";
}

$conn->close();


echo "<p><BR><font color=\"red\">" . $sql . "</font></p>";   #6. Reflected XSS


//https://www.w3schools.com/php/php_mysql_select.asp

?>

</body>
</html>
