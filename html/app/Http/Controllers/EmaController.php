<?php

namespace App\Http\Controllers;

use App\Models\ema;

class EmaController extends Controller
{
    public function getSubjects($exam)
    {   
        //return list of subjects for given exam
        $subjects = array();
        $query = ema::where('exam', $exam)
                    ->select('subject')
                    ->distinct()
                    ->orderBy('subject', 'asc')
                    ->get();
        foreach($query as $row) {
            array_push($subjects, $row->subject);
        }
        return json_encode($subjects);
    }

    public function getYears($exam, $subject)
    {
        //return list of years for given exam and subject
        $years = array();
        $query = ema::where('exam', $exam)
                        ->where('subject', $subject)
                        ->select('year')
                        ->distinct()
                        ->orderBy('year', 'desc')
                        ->get();
        foreach($query as $row) {
            array_push($years, $row->year);
        }
        return json_encode($years);
    }

    public function getMaterials($exam, $subject, $year)
    {
        //return list of materials for given exam, subject and year
        $query = ema::where('exam', $exam)
                        ->where('subject', $subject)
                        ->where('year', $year)
                        ->select('type', 'resname', 'reslink')
                        ->get();
        $query->groupBy('type');
        return json_encode($query->toArray());
    }
}
