<?PHP
//DB info
$servername = "localhost:3306";
$username = "PHP";
$password = "";
$db="es-mediumtables";

//New Connection
$conn = new mysqli($servername, $username, $password, $db);
	              
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
$ip = strval($_SERVER['REMOTE_ADDR']);
//insert timestamp
$query = "INSERT INTO clicks VALUES (CURRENT_TIMESTAMP, INET_ATON('$ip'))";
$conn->query($query);
