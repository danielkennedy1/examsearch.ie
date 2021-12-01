<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Repository\MaterialRepository;
use function PHPSTORM_META\type;

class ResultsController extends Controller
{   
    public function show(Request $request, MaterialRepository $materialRepository) {
        
        $exam = $request -> input("exam");
        $subject = $request -> input("subject");
        $isFiltered = $request -> input("isFiltered");
        $lang = $request -> input("lang");
        $level = $request -> input("lvl");

        if($materialRepository::validate($exam, $subject)){
            //valid exam, subject pair
            $results = $materialRepository::get_material($exam, $subject, $isFiltered, $lang, $level);
            return view("results", [
                "results" => $results,
                "typename" => $materialRepository::typename,
                "exam" => $exam,
                "subject" => $subject,
                "fullexamname" => $materialRepository::fullexamnames[$exam],
                "title" => $materialRepository::fullexamnames[$exam] . " " . $subject
            ]);
        }else{
            //invalid exam, subject pair
            return redirect("/");
        }
    }

}
