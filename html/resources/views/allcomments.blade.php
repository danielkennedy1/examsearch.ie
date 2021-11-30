@extends("templates.template")

@section("title")
    Examsearch Admin - All comments
@endsection

@section("content")
    @foreach($comments as $comment)
            @php
                $comment_text = $comment->comment;
                $author = $usersmodel::where("id", $comment->user_id)->first()["name"];
                $author_email = $usersmodel::where("id", $comment->user_id)->first()["email"];
                $discussion = $discussionmodel::where("id", $comment->discussion_id)->first();
            @endphp
            <div class="card">
                <div class="card-header">
                    {{$author}} ({{$author_email}}) | {{$discussion["exam"]}} {{$discussion["subject"]}} {{$discussion["year"]}} | ID: {{$discussion["id"]}}
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                    <p>{{$comment_text}}</p>
                    </blockquote>
                </div>
            </div>
    @endforeach
@endsection