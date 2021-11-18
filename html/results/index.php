<?php
$exam = $_GET['exam'];
$subject = $_GET['subject'];
$clean_subject = str_replace(" ", "_", $subject);
$servername = "localhost:3306";
$username = "root";
$password = "";
$db="examsearch";
$years = [];  
$examdict = [
  "jc" => "Junior Certificate",
  "lc" => "Leaving Certificate",
  "lca" => "Leaving Certificate Applied"
];
$results = false;
//year table name
$table = "$exam-$clean_subject";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}


function lang($lang){
	if($lang == "irish"){
		return "AND resname NOT LIKE '%(EV)%'";
	}elseif($lang == "english"){
		return "AND resname NOT LIKE '%(IV)%'";
	}else{
		return NULL;
	}
	}
//adds level filter to request
//omits levels not selected instead of only allowing selected level, 
//to allow for common level papers, sound files, etc
function lvl($level){
	if($level == "Higher"){
		return "AND resname NOT LIKE '%Ordinary%' AND resname NOT LIKE '%Foundation%'";
	}
	elseif($level == "Ordinary"){
		return "AND resname NOT LIKE '%Higher%' AND resname NOT LIKE '%Foundation%'";
	}
	elseif($level == "Foundation"){
		return "AND resname NOT LIKE '%Higher%' AND resname NOT LIKE '%Ordinary%'";
	}
	else{
		return NULL;
	}
	}
function printtype($input){
	if($input == "exam"){
		return "Exam Paper";
	}elseif($input == "mark"){
		return "Marking Scheme";
	}
}
function downloadlink($resultlink, $thisdownloadname){
	$extension = ".mp3";
	//strpos returns false if not present, position of substring if present
	if (strpos($resultlink, $extension) !== false) {
		//called if link has .mp3 extension
		return; 
	}else{
		//called if link does not have .mp3 extension
		return "<a class='btn btn-success' href='download.php?file=$resultlink&name=$thisdownloadname'>Download</a>";
	}
}
//Message if there isn't an exam or subject selected (people changing the url)
function errcheck(){
	if($_GET["exam"] == NULL || $_GET["subject"] == NULL){
		die("not sufficient info for results, please return <a href='../'><u>home</u></a><br>");
	}
}
//tracks uses
if($_GET['isFiltered'] != 'true'){
	@$update_query = "UPDATE `uses` SET `uses`= `uses` + 1 WHERE exam = '${_GET['exam']}' AND subject = '${_GET['subject']}'";
	$conn->query($update_query);
	};



//make array of years
@$sql_years_query = "SELECT DISTINCT `year` FROM `$table` ORDER BY `year` DESC";
$yearres = $conn->query($sql_years_query);
if ($yearres->num_rows > 0) {
	global $years;
	global $results;
	//if there is results	
	$results = true;
	//this is called for every different year in results set
	while($thisyr = $yearres->fetch_assoc()) {
		global $years;
		//($thisyr is the row, ["year"] refers to the column name)
		$years[$thisyr["year"]] = [
				"exam" => [], 
				"mark" => []
			];
};
} else {
	//if there is no results
	$results = false;
}
foreach(array_keys($years) as $i){			
	global $table;
	@$query =  
	"SELECT `type`,`resname`, `reslink`
	FROM `$table`
	Where `year` = $i";
	@$result = $conn->query($query);
	if (@$result->num_rows > 0) {
			while($thisres = $result->fetch_assoc()) {
			global $years;
			array_push($years[$i][$thisres["type"]], array($thisres["resname"], $thisres["reslink"]));
			};
		}
	

}
//$years["each yr"]["exam"/"mark"][0..however many results][[0] => resname, [1] => reslink]



?>

<!DOCTYPE html>

<html>
<head>
	<title>Past Papers Organised - Examsearch.ie</title>
	<!--Browser Stuff-->
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!--Favicons, etc.-->
	<meta content="noindex, nofollow" name="robots">
	<link rel="icon" type="image/x-icon" href="../favicon.ico">
	<link href="http://examsearch.ie/" rel="canonical">
	<link rel="apple-touch-icon" sizes="180x180" href="../images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../images/favicon-16x16.png">
	<link rel="manifest" href="../site.webmanifest">
	<link rel="mask-icon" href="../images/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">
	<!--Bootstrap-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
 	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	 <script>

		 function count() {
  			$.ajax({
   				url:'click.php',
				type:'GET',
				success:function(data){
					body.append(data);
				}
			});
		}
	 </script>
</head>

<body>
	<!--Navbar-->
	<ul class="nav nav-tabs justify-content-center">
	<li class="nav-item">
		<a class="nav-link" href="../">Home</a>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Exams</a>
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
	<?php
		@errcheck();
		if($results){
			echo "<h1>${examdict[$exam]} $subject</h1>";
		}else{
			echo "<p class='box'>It appears there is no material for the filters you have selected</p>";
		}
	?>
	<a class="btn btn-dark btn-lg" href="javascript:history.back()">Back</a>
	<div class="text-center">
		<a href="https://www.themathstutor.ie/examsearch/">
			<img src="../images/ad.png" style="max-height: 12.36vw;max-width: 100vw;margin:auto;border:2px solid black" onclick="count()">
		</a>
	</div>
	<form class="jumbotron" action="">
		<input type="hidden" name="exam" value="<?=$_GET['exam']?>">
		<input type="hidden" name="subject" value="<?=$_GET['subject']?>">
		<input type="hidden" name="isFiltered" value="true">
		<h1>Filters <input class="btn btn-danger" type="reset"></h1>
		<h1>Language</h1>
		<div class="btn-group btn-group-toggle btn-lg" data-toggle="buttons">
			<label class="btn btn-primary">
				<input type="radio" name="lang" value="english" autocomplete="off"> English
			</label>
			<label class="btn btn-primary">
				<input type="radio" name="lang" value="irish" autocomplete="off"> Irish
			</label>
		</div>
		<h1>Level</h1>
		<div class="btn-group btn-group-toggle btn-lg" data-toggle="buttons" style="padding:0px">
			<label class="btn btn-primary">
				<input name="lvl" type="radio" value="Higher" autocomplete="off"> Higher
			</label>
			<label class="btn btn-primary">
				<input name="lvl" type="radio" value="Ordinary" autocomplete="off"> Ordinary
			</label>
			<label class="btn btn-primary">
				<input name="lvl" type="radio" value="Foundation" autocomplete="off"> Foundation
			</label>
		</div>
		<br>
		<input class="btn btn-success btn-lg" type="submit" value="Apply">
	</form>
	<?php
		//OUTPUT
		foreach($years as $year => $thisyr){
			echo "<h1>" . $year . "</h1>";
			//container for each year group
			echo "<div class='row'>";
			//year heading
			//echo "<div class='box'> this is where box starts";
			foreach(array_keys($thisyr) as $thistype){
				//exam or mark heading
				echo "<div class='col'>";
				echo "<div>";
				echo "<h3 class='typeheading'>" . printtype($thistype) . "</h3>";
				foreach($thisyr[$thistype] as $thisres){
					//$thisres[0] is resname, [1] is reslink
					//prints out name -- link  --- download link
					@$downloadname =  "${examdict[$_GET['exam']]} ${_GET['subject']} " . 
					$year . " ${thisres[0]} " . printtype($thistype);


					echo "<p>" . " ${thisres[0]} <a class='btn btn-primary' target='_blank' 
					href='${thisres[1]}'>View</a> " . downloadlink($thisres[1], $downloadname) . "</p>";
				}
				echo  "</div></div>";
			}
			echo "</div>";
			
		}
		//close up the sql connection
		$conn->close(); 
	?>
</body>
</html>