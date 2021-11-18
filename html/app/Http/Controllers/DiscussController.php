<?php

namespace App\Http\Controllers;


use App\Repository\MaterialRepository;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;


class DiscussController extends Controller
{
    public function show(Request $request, MaterialRepository $materialRepository){
        $exam = $request -> input("exam");
        $subject = $request -> input("subject");
        $year = $request -> input("year");
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
            ]);
        }else{
            return redirect("/");
        }
    }
}
