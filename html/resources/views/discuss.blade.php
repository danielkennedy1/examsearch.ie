@extends("templates.template")
@section("title")
    {{$title}}
@endsection
@section("content")
    <h1>{{$title}}</h1>
    @foreach($material as $year => $typearray)
        <div class="row">
        @foreach(array_keys($typearray) as $thistype)
            <div class="col">
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
@endsection