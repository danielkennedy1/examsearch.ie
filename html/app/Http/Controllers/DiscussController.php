<?php

namespace App\Http\Controllers;


use App\Repository\MaterialRepository;
use Illuminate\Http\Request;
use App\Models\Discussion;
use App\Models\Mycomment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DiscussController extends Controller
{
    public function show(Request $request, MaterialRepository $materialRepository){
        $exam = $request -> input("exam");
        $subject = $request -> input("subject");
        $year = $request -> input("year");
        $level = "";
        $level = $request -> input("lvl");

        if($materialRepository::validate($exam, $subject)){
            
            $discussion = Discussion::where("exam", $exam)->where("subject", $subject)->where("year", $year)->first();
            $discussion->increment("views");
            $myComments = Mycomment::where("discussion_id", $discussion->id)->where("approved", 1)->get();
            $unapproved = Mycomment::where("user_id", Auth::id())->where("approved", 0)->get();
            $users = array();
            foreach($myComments as $comment){
                array_push($users, User::where("id", $comment->user_id)->get("name")[0]["name"]);
            }
            $material = $materialRepository::get_material($exam, $subject, "true", "", $level, $year);
            $title = strtoupper($exam) . " " . ucfirst($subject) . " $year";
            return view("discuss", [
                "material" => $material,
                "title" => $title,
                "exam" => $exam,
                "subject" => $subject,
                "typename" => $materialRepository::typename,
                "fullexamname" => $materialRepository::fullexamnames[$exam],
                "discussion" => $discussion,
                "mycomments" => $myComments,
                "users" => $users,
                "unapproved" => $unapproved
            ]);
        }else{
            return redirect("/");
        }
    }
}
