@extends('templates.template')
@section('title')
{{$title}}
@endsection
@section('content')
    <h1>{{$title}}</h1>
	<a class="btn btn-dark btn-lg" href="javascript:history.back()">Back</a>
	<div class="text-center sticky-top my-4">
		<a href="/ad">
			<img src="../images/mathstutor.png" style="max-height: 12.36vw;max-width: 100vw;margin:auto;border:2px solid black">
		</a>
	</div>
    <!--Filters-->
    <form class="jumbotron" action="">
        <input type="hidden" name="exam" value="{{$exam}}">
        <input type="hidden" name="subject" value="{{$subject}}">
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
    <!--Results-->
    <div class="container">
    @foreach($results as $year => $typearray)
        <h1>
            {{$year}}
            <a class="btn btn-warning btn-lg" href="/discuss?exam={{$exam}}&subject={{$subject}}&year={{$year}}">
                Discuss
            </a>
        </h1>
        <div class="row">
        @foreach(array_keys($typearray) as $thistype)
            <div class="col flex-row">
            {{--If there is results for given type heading, otherwise col is left empty--}}
            {{--Prevents type headings with no results under them--}}
            @if($typearray[$thistype])
                <div>
                    <h3>{{$typename[$thistype]}}</h3>
                </div>
                @foreach($typearray[$thistype] as $result_pair)
                    <p>
                        {{$result_pair[0]}} 
                        <a class='btn btn-primary' target='_blank' href='{{$result_pair[1]}}'>View</a>
                        {{--Do not make a download button for .mp3 files--}}
                        @if(str_contains($result_pair[1], ".mp3" ) == false)
                            <a class='btn btn-success' href='/download?file={{$result_pair[1]}}
                            &name={{$fullexamname}} {{$subject}} {{$year}} {{$result_pair[0]}} {{$typename[$thistype]}}'>
                                Download
                            </a>
                        @endif                     
                    </p>
                @endforeach      
            @endif      
            </div>
        @endforeach
        </div>
    @endforeach
    </div>
@endsection