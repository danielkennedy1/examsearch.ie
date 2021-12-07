<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\MyComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function show(User $user, Discussion $discussion){
        $unapprovedComments = MyComment::where("approved", 0)->get();

        return view("admin", [
            "unapprovedComments"=>$unapprovedComments,
            "usersmodel" => $user,
            "discussionmodel" => $discussion
        ]);
    }

    public function approve(Request $request){
        $approved_id = $request->input("approved-id");
        MyComment::where("id", $approved_id)->update(["approved" => 1]);
        return redirect()->back();
    }

    public function all(User $user, Discussion $discussion){
        return view("allcomments", 
        ["comments" => MyComment::all(),
         "usersmodel" => $user,
         "discussionmodel"=>$discussion
    ]);
    }
}
