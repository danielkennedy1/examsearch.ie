@extends('templates.template')
@section('title')
Past Papers Organised - Examsearch.ie
@endsection
@section('header-stuff')
	<!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script src="/main.js" defer></script>
    <link rel="stylesheet" href="/style.css">
@endsection
@section('content')
<div class="container py-3">
        <div class="row my-3">
            <div class="col md-12">
                <h1 class="text-grey d-inline"> <img src="/images/blank-logo.png" alt="examsearch logo" class="title-logo"> ExamSearch <button id="questionMarkButton" data-toggle="collapse" href="#tutorial"><x-question /></button></h1>
            </div>
        </div>
        <div class="row collapse" id="tutorial">
            <div class="col py-4">
                <p><strong>Tutorial</strong> <br>
                    Select an exam, then begin typing a subject name, then select the year you wish to view. <br><br>
                    You can filter by language and level by clicking the appropriate buttons. To deselect a filter, click/press the selected option again. <br><br>
                    Finally, choose the paper you wish to view. <br><br>
                </p>
            </div>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <button id="examDropdown" class="btn btn-primary dropdown-toggle" type="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Select Exam</button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" id="lc">Leaving Certificate</a>
                    <a class="dropdown-item" id="jc">Junior Certificate</a>
                    <a class="dropdown-item" id="lca">Leaving Certificate Applied</a>
                </div>
            </div>
            <input id="searchBar" type="text" class="form-control" placeholder="Subject" disabled>
            <script src="/autocomplete.js"></script>
            <div class="input-group-append">
                <button id="yearSelect" class="btn btn-primary dropdown-toggle" type="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled>Select Year</button>
                <div id="yearList" class="dropdown-menu">
                </div>
            </div>
        </div>
        <div class="jumbotron">
            <div class="row my-4" id="ad">
                <div class="col text-center">
                    <a href="https://www.themathstutor.ie/examsearch/">
                        <img src="/images/mathstutor.png" class="border border-dark" style="max-width:100%">
                    </a>
                </div>
            </div>
            <div class="row my-3">
                <div class="col" id="resultsTitleContainer"></div>
            </div>
            <!-- filter -->
            <div id="filters" class="collapse">
                <div class="row">
                    <div class="col my-3 md-12">
                        <h4 class="d-inline">Language: </h4>
                        <div id="lang" class="btn-group" role="group" aria-label="language filter">
                            <button value="EV" type="button" class="btn btn-outline-dark">English</button>
                            <button value="IV" type="button" class="btn btn-outline-dark">Irish</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3 md-12">
                        <h4 class="d-inline">Level: </h4>
                        <div id="lvl" class="btn-group" role="group" aria-label="level filter">
                            <button value="Higher" type="button" class="btn btn-outline-dark">Higher</button>
                            <button value="Ordinary" type="button" class="btn btn-outline-dark">Ordinary</button>
                            <button value="Foundation" type="button" class="btn btn-outline-dark">Foundation</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="results" class="row">
            </div>
        </div>
    </div>
<p class="text-center">Exam papers in some subjects dating as far back as 1925 courtesy of Malone, D and Murray, H. <a href="https://archive.maths.nuim.ie/staff/dmalone/StateExamPapers/">Source</a></p>
@endsection
