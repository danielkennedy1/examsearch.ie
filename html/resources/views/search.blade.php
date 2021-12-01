
@extends('templates.template')
@section('title')
{{$examname}}
@endsection
@section('header-stuff')
<style>
    html{
        scroll-behavior: smooth;
    }
    * { 
        box-sizing: border-box; 
    }
    
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
    var subjects = {!! $subjects_json !!};
</script>
@endsection
@section('content')
        <!--Heading-->
		<h1 style="font-weight:lighter">{{$examname}}</h1> 
        	<!--Form-->
		<form autocomplete="off" action="../results/">
            <input type="hidden" name="exam" value="{{$exam}}">
            <input type="hidden" name="isFiltered" value="false">
                <div class="autocomplete" style="width:300px;">
                    <input id="myInput" type="text" name="subject" placeholder="Search">
                </div>
            <input value="Go!" type="submit">
            </form>
            <br />
        <div class='jumbotron jumbotron-fluid'>
            
		@foreach(range('A', 'Z') as $letter)
			<a class='btn btn-primary btn-lg mx-2 my-2' href='#{{$letter}}'><h1 class='display-4'>{{$letter}}</h1></a><wbr>
		@endforeach
		
        </div>

<form action="../results/">
    <input type="hidden" name="isFiltered" value="false">
    <input type="hidden" name="exam" value="{{$exam}}">
@php
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
		//if there's a new first letter in the subject value,
		//print out a letter title
		if($currentletter !== $a){
			lettertitle($currentletter);
		}
		echo subbutton($thissub);
		$a = substr($thissub, 0, 1);
	};
@endphp
</form>
<!--Script for search bar-->
<script src="/main.js"></script>
@endsection