<?php
namespace App\Repository;

use Illuminate\Support\Facades\DB;


class MaterialRepository {
    public static function validate($_exam, $_subject){

        if(in_array($_exam, ["jc", "lc", "lca"])){
            $subject_exists = DB::select("SELECT 1 from `$_exam` WHERE `subject` = '$_subject'");
            if($subject_exists){
                return true;
            }
        }else{
            return false;
        }
    }
    public static function get_material($_exam, $_subject, $_isFiltered = "false", $_lang = "", $_level = "", $_year = 0){
        if($_isFiltered == "false"){
            DB::table("uses")
                ->where(["exam" => $_exam, "subject" => $_subject])
                ->increment("uses");
        }
        $_results = array();
        $clean_subject = str_replace(" ", "_", $_subject);
        $tablename = "$_exam-$clean_subject";
        if($_year){//for single year queries (Discussion Pages)
            $_results[$_year] = [
                "exam" => [], 
				"mark" => []
            ];
        }else{
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
        }
            foreach(array_keys($_results) as $year){
            $res = DB::table($tablename)
                    ->select("type", "resname", "reslink")
                    ->where("year", "=", $year)
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
                    error_log($res -> toSql());
                    
                    $material = $res -> get();
                    foreach($material as $row){
                        array_push($_results[$year][$row->type], array($row->resname, $row->reslink));
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
}