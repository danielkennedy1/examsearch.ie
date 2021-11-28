@extends("templates.template")
@section("title")
    {{$title}}
@endsection
@section("content")
    <div class="container">
    <h1>{{$title}}</h1>
    <br>
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
    {{--
    </div>
    <div class="container">
        <div id="disqus_thread"></div>
    </div>
    
    <script>
        /**
        *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
        *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
        
        var disqus_config = function () {
        this.page.url = "{{url()->full()}}";  // Replace PAGE_URL with your page's canonical URL variable
        this.page.identifier = "{{$title}}"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        };
        
        (function() { // DON'T EDIT BELOW THIS LINE
        var d = document, s = d.createElement('script');
        s.src = 'https://examsearch.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    --}}
    <hr>
    <h1>Discussion</h1>
    @comments(["model" => $discussion,
                "mycomments"=>$mycomments,
                "users" =>$users,
                "unapproved = $unapproved"])
@endsection