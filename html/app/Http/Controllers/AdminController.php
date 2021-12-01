<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Mycomment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function show(User $user, Discussion $discussion){
        $unapprovedComments = Mycomment::where("approved", 0)->get();

        return view("admin", [
            "unapprovedComments"=>$unapprovedComments,
            "usersmodel" => $user,
            "discussionmodel" => $discussion
        ]);
    }

    public function approve(Request $request){
        $approved_id = $request->input("approved-id");
        Mycomment::where("id", $approved_id)->update(["approved" => 1]);
        return redirect()->back();
    }

    public function all(User $user, Discussion $discussion){
        return view("allcomments", 
        ["comments" => Mycomment::all(),
         "usersmodel" => $user,
         "discussionmodel"=>$discussion
    ]);
    }
}
