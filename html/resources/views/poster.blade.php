@extends("templates.template")
@section("header-stuff")
<style>
    #pdflink {
        max-height: 100vh;
        text-decoration: none;
        color: white;
    }
    #posterbox{
        width:100vw;
        height:auto;
        display:flex;
        flex-direction: column;
        align-items: center;
    }
</style>
@endsection
@section("content")
<div id="posterbox">
            <img style="max-width: 75vw;max-height: 75vh;" src="/examsearch-poster.png">
            <button class="btn btn-warning">
                <a id="pdflink" href="/examsearch-poster.pdf">
                    <h1>
                        Print PDF
                    </h1>
                </a>
            </button>
        </div>
@endsection