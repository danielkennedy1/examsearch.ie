<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Repository\MaterialRepository;

class SearchController extends Controller
{
    public function show(Request $request, MaterialRepository $materialRepository){
        $exam = $request -> input("exam");
        if(in_array($exam, ["jc", "lc", "lca"])){
            $db_response = DB::select("SELECT `subject` from $exam ORDER BY `subject` ASC");
            $subjects = array();
            foreach($db_response as $tablerow){
                global $subjects;
                $subjects[] = $tablerow->subject;
            }
            $examname = $materialRepository::fullexamnames[$exam];
            $subjects_json = json_encode($subjects);
            return view('search', [ 'subjects' => $subjects, 
                                    'exam' => $exam, 
                                    'examname' => $examname,
                                    'subjects_json' => $subjects_json
                                ]);
        }else{
        return redirect("/");
        }
    }
}
