@extends('templates.template')
@section('title')
Past Papers Organised - Examsearch.ie
@endsection
@section('content')
<!--Heading Image-->
<img class="mx-auto d-block img-fluid" src="images/logo.png">
<!--Row of buttons-->
<div class="btn-toolbar justify-content-center">
		<a href="search/?exam=jc" class="btn btn-primary"><h1 style="font-weight:lighter">Junior Certificate</h1></a>
		<a href="search/?exam=lc" class="btn btn-success"><h1 style="font-weight:lighter">Leaving Certificate</h1></a>
		<a href="search/?exam=lca" class="btn btn-primary"><h1 style="font-weight:lighter">Leaving Certificate Applied</h1></a>
</div>
<p class="text-center">Exam papers in some subjects dating as far back as 1925 courtesy of Malone, D and Murray, H. <a href="https://archive.maths.nuim.ie/staff/dmalone/StateExamPapers/">Source</a></p>
@endsection
