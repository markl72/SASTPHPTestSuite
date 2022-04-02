<html>
<body>

<?php

$dbserver = "localhost";
$dbuserid = "insecureapp";
$dbpassword = "45EUlZOpL7";		#1. Hardcoded password
$db = "insecureapp";

$userid = $_POST["userid"];
$password = $_POST["password"];

echo "<p>userid: " . $userid . "</p>";		#2. Reflected XSS
echo "<p>password: " . $password . "</p>";	#3. Reflected XSS

$conn = new mysqli($dbserver, $dbuserid, $dbpassword, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


// print account details

$sql = "SELECT * FROM users WHERE userid=? AND password=?";	

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $userid, $password);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

	// print heading
	echo "<H1>Your Account</H1>";
	echo "<p>Welcome, your account details are:</p>";

	while($row = $result->fetch_assoc()) {
        echo " <p>Name: " . htmlentities($row["lastname"]). ", " . htmlentities($row["firstname"]). " <BR>Address: " . htmlentities($row["address"]). "<br>Phone number: " . htmlentities($row["phone"]) . "</p>"; #5. Stored XSS
    }
}
else
{
echo "<p><b>Login failed</b></p>";
}


$conn->close();


echo "<p><BR><font color=\"red\">" . $sql . "</font></p>";	#6. Reflected XSS


//https://websitebeaver.com/prepared-statements-in-php-mysqli-to-prevent-sql-injection

?>

</body>
</html>
