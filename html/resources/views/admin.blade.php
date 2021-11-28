@extends("templates.template")
@section("title")
    Examsearch Admin Panel
@endsection
@section("content")
    @if(!count($unapprovedComments))
        <div class="alert alert-info">There are no unapproved comments!</div>
    @else
    @endif

    @foreach($unapprovedComments as $num =>$comment)
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
                    <a href="{{ route('comments.destroy', $comment->getKey()) }}" onclick="event.preventDefault();document.getElementById('comment-delete-form-{{ $comment->getKey() }}').submit();" class="btn btn-sm btn-link text-danger text-uppercase">@lang('comments::comments.delete')</a>
                    <form id="comment-delete-form-{{ $comment->getKey() }}" action="{{ route('comments.destroy', $comment->getKey()) }}" method="POST" style="display: none;">
                        @method('DELETE')
                        @csrf
                    </form>
                    <a href="{{"/admin/approve" . $comment->getKey()}}" onclick="event.preventDefault();document.getElementById('comment-approve-form-{{ $comment->getKey() }}').submit();" class="btn btn-sm btn-link text-success text-uppercase">Approve</a>
                    <form id="comment-approve-form-{{ $comment->getKey() }}" action="/admin/approve" method="post">
                        @csrf
                        <input type="hidden" name="approved-id" value="{{$comment->id}}">
                    </form>
                    </blockquote>
                </div>
            </div>
    @endforeach
@endsection