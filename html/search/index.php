3<?php 
$fullexamname = [
	"jc" => "Junior Certificate",
	"lc" => "Leaving Certificate",
	"lca" => "Leaving Certificate Applied"
];
$exam = $_GET['exam'];
$subjects = [];
$servername = "localhost:3306";
$username = "root";
$password = "";
$db="examsearch";
//SQL CONNECTION
$conn = new mysqli($servername, $username, $password, $db);
//Connection Error
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
	}
//below is query for subjects
@$subjects_query = "SELECT DISTINCT `subject` FROM `$exam` ORDER BY `subject` ASC";
@$subresult = $conn->query($subjects_query);
if (@$subresult->num_rows > 0) {
	//this is called for every different subject in results set
	while($currentsub = $subresult->fetch_assoc()) {
		global $subjects;
		array_push($subjects, $currentsub['subject']);
	};
	};
$conn -> close();

?>

<!DOCTYPE html>

<html>
<head>
	<title><?=$fullexamname[$_GET['exam']]?></title>
	<!--Browser Stuff-->
	<meta charset="utf-8">	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content="index, nofollow" name="robots">
	<!--icons, etc-->
	<link href="http://examsearch.ie/" rel="canonical">
	<link rel="icon" type="image/x-icon" href="../favicon.ico">
	<link rel="apple-touch-icon" sizes="180x180" href="../images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../images/favicon-16x16.png">
	<link rel="manifest" href="../site.webmanifest">
	<link rel="mask-icon" href="images/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
 	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<style>
		html{
			scroll-behavior: smooth;
		}
		* { box-sizing: border-box; }
body {
  font: 16px Arial;
}
.autocomplete {
  /*the container must be positioned relative:*/
  position: relative;
  display: inline-block;
}
input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}
input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}
input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
}
.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}
.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff;
  border-bottom: 1px solid #d4d4d4;
}
.autocomplete-items div:hover {
  /*when hovering an item:*/
  background-color: #e9e9e9;
}
.autocomplete-active {
  /*when navigating through the items using the arrow keys:*/
  background-color: DodgerBlue !important;
  color: #ffffff;
}
	</style>

<script>
	document.addEventListener("keypress", (event) => {
		var inputBox = document.getElementById('myInput');
		var isEventInside = inputBox.contains(event.target);
		if (!isEventInside) {
			var letter = "#" + event.key.toUpperCase();
			window.location = letter;
		}
	}, false);

</script>
</head>

<body>
		<!--Navbar-->
	<ul class="nav nav-tabs justify-content-center">
	<li class="nav-item">
		<a class="nav-link" href="../">Home</a>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle active" data-toggle="dropdown" href="#">Exams</a>
		<div class="dropdown-menu">
		<a class="dropdown-item" href="../search/?exam=jc">Junior Certificate</a>
		<a class="dropdown-item" href="../search/?exam=lc">Leaving Certificate</a>
		<a class="dropdown-item" href="../search/?exam=lca">Leaving Certificate Applied</a>
		</div>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="../contact/">Contact</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="../poster/">Poster</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="../tc/">Terms & Conditions</a>
	</li>
	</ul>
	<script>
		var subjects = <?=json_encode($subjects)?>;
		</script>
		<div class="col">
		<!--Heading-->
		<h1 style="font-weight:lighter"><?=$fullexamname[$_GET['exam']]?></h1>
		
		<!--Form-->
		<form autocomplete="off" action="../results/">
		<input type="hidden" name="exam" value="<?=$_GET['exam']?>">
		<input type="hidden" name="isFiltered" value="false">
		<div class="autocomplete" style="width:300px;">
			<input id="myInput" type="text" name="subject" placeholder="Search">
		</div>
		<input value="Go!" type="submit">
		</form>
		<form action="../results/">
		<input type="hidden" name="isFiltered" value="false">
		<input type="hidden" name="exam" value="<?=$_GET['exam']?>">
	</div>
	<br>
	<!--Letter Box-->	
	<?php
		echo "<div class='jumbotron jumbotron-fluid'>";
		$alphas = range('A', 'Z');
		foreach($alphas as $letter){
			echo "<a class='btn btn-primary btn-lg mx-2 my-2' href='#$letter'><h1 class='display-4'>$letter</h1></a><wbr>";
		}
		echo "</div>";

		?>
		
		<a href="#" class="btn btn-dark sticky-top">
		<p class='display-4'>Top</p>
		</a>

		<?php
	//function returns str with input classed 'subject' and value as text
	function subbutton($subject){
		return "<input type='submit' class='btn btn-primary btn-block btn-lg mx-auto' style='width:auto' name='subject' value='$subject'><br>";
	}


	function lettertitle($letter){
		echo "<button type='button' class='btn btn-success btn-block btn-lg mx-auto' id='$letter' style='width:auto'><p class='display-4'>$letter</p></button>";
	}

	$a = "";
	foreach($subjects as $thissub){
		global $a;
		$currentletter= substr($thissub, 0, 1);
		//if theres a new first letter in the subject value,
		//print out a letter title
		if($currentletter !== $a){
			lettertitle($currentletter);
		}
		echo subbutton($thissub);
		$a = substr($thissub, 0, 1);
	};
	?>
	</form>
<!--Script for search bar-->
<script src="main.js"></script>
</body>
</html>