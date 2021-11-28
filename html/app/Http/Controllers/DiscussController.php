<?php

namespace App\Http\Controllers;


use App\Repository\MaterialRepository;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Models\Discussion;
use App\Models\Mycomment;
use App\Models\User;

class DiscussController extends Controller
{
    public function show(Request $request, MaterialRepository $materialRepository){
        $exam = $request -> input("exam");
        $subject = $request -> input("subject");
        $year = $request -> input("year");
        $discussion = Discussion::where("exam", $exam)->where("subject", $subject)->where("year", $year)->first();
        $myComments = Mycomment::where("discussion_id", $discussion->id)->get();

        $users = array();
        foreach($myComments as $comment){
            array_push($users, User::where("id", $comment->user_id)->get("name")[0]["name"]);
        }
        if($materialRepository::validate($exam, $subject)){
            $material = $materialRepository::get_material($exam, $subject, "true", "", "", $year);
            $title = strtoupper($exam) . " $subject $year";
            return view("discuss", [
                "material" => $material,
                "title" => $title,
                "exam" => $exam,
                "subject" => $subject,
                "typename" => $materialRepository::typename,
                "fullexamname" => $materialRepository::fullexamnames[$exam],
                "discussion" => $discussion,
                "mycomments" => $myComments,
                "users" => $users
            ]);
        }else{
            return redirect("/");
        }
    }
}
