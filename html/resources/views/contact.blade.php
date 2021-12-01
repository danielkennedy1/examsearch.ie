@extends("templates.template")
@section("header-stuff")
<style>
#form{
    top:0;
    left:0;
    bottom:0; 
    right:0; 
    width:75vw; 
    height:150vh;
    overflow: auto; 
    background-color: rgb(255, 255, 255, .6);
    border:10px solid transparent; 
    border-radius: 20px;
    margin:auto; 
    padding:0; 
    z-index:999999;
}
</style>
@endsection
@section("content")
<iframe src="https://docs.google.com/forms/d/e/1FAIpQLScFJB3H0ElcDIFr39_z-Aq28shC3qHQ2lEnoIP5Y5T73kqqYg/viewform?embedded=true" id="form">Loading…</iframe>
@endsection