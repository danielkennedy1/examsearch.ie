<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class ResultsController extends Controller
{   
    public static function resultsvalidate($_exam, $_subject){

        if(in_array($_exam, ["jc", "lc", "lca"])){
            $subject_exists = DB::select("SELECT 1 from `$_exam` WHERE `subject` = '$_subject'");
            if($subject_exists){
                return true;
            }
        }else{
            return false;
        }
    }

    public static function get_results($_exam, $_subject, $_isFiltered, $_lang, $_level){
        if($_isFiltered == "false"){
            DB::table("uses")
                ->where(["exam" => $_exam, "subject" => $_subject])
                ->increment("uses");
        }
        $_results = array();
        $clean_subject = str_replace(" ", "_", $_subject);
        $tablename = "$_exam-$clean_subject";
        //find years for given exam, subject combination
        $yearres = DB::select("SELECT DISTINCT `year` FROM `$tablename` ORDER BY `year` DESC");
        //for each year make _results[year] = [array with exam, mark arrays]
        foreach($yearres as $year_row){
            //global $_results;
            $_results[$year_row->year] = [
                "exam" => [], 
				"mark" => []
            ];
        };
            foreach(array_keys($_results) as $_year){
            $res = DB::table($tablename)
                    ->select("type", "resname", "reslink")
                    ->where("year", "=", $_year)
                    ->when(($_lang == "irish"), function($query){
                        $query -> where("resname",  "NOT LIKE",  "%(EV)%");
                    })
                    ->when(($_lang == "english"), function($query){
                        $query -> where("resname",  "NOT LIKE",  "%(IV)%");
                    })
                    ->when(($_level == "Higher"), function($query){
                        $query -> where("resname",  "NOT LIKE", "%Ordinary%") 
                                -> where("resname", "NOT LIKE", "%Foundation%");
                    })
                    ->when(($_level == "Ordinary"), function($query){
                        $query -> where("resname",  "NOT LIKE", "%Higher%") 
                                -> where("resname", "NOT LIKE", "%Foundation%");
                    })
                    ->when(($_level == "Foundation"), function($query){
                        $query -> where("resname",  "NOT LIKE", "%Higher%") 
                                -> where("resname", "NOT LIKE", "%Ordinary%");
                    });
                    
                    
                    $material = $res -> get();
                    foreach($material as $row){
                        array_push($_results[$_year][$row->type], array($row->resname, $row->reslink));
                    }
            };
            return $_results;
        }

    public const fullexamnames = [
        "jc" => "Junior Certificate",
        "lc" => "Leaving Certificate",
        "lca" => "Leaving Certificate Applied"
    ];
    public const typename = [
        "exam" => "Exam Paper",
        "mark" => "Marking Scheme"
    ];

    public function show(Request $request) {
        $exam = $request -> input("exam");
        $subject = $request -> input("subject");
        $isFiltered = $request -> input("isFiltered");
        $lang = $request -> input("lang");
        $level = $request -> input("lvl");
        if(Self::resultsvalidate($exam, $subject)){
            //valid exam, subject pair
            $results = Self::get_results($exam, $subject, $isFiltered, $lang, $level);
            return view("results", [
                "results" => $results,
                "typename" => Self::typename,
                "exam" => $exam,
                "subject" => $subject,
                "fullexamname" => Self::fullexamnames[$exam],
                "title" => Self::fullexamnames[$exam] . " " . $subject
            ]);
        }else{
            //invalid exam, subject pair
            return redirect("/");
        }
    }

}
