<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    private const validLinks = [
        "https://www.examinations.ie/exammaterialarchive/?fp=",
        "https://archive.maths.nuim.ie/staff/dmalone/StateExamPapers/"
    ];

    public function download(Request $request){
        $inputname = $request -> input("name");
        $name = str_replace("/", "", $inputname) . ".pdf"; # Cannot save files with "/" in name
        $path = $request -> input("file");
        $valid_links = Self::validLinks;

        if(substr($path, 0, 52) == $valid_links[0] | substr($path, 0, 60) == $valid_links[1] ){

            $file = uniqid() . ".pdf";

            file_put_contents($file, file_get_contents($path));

            return response() -> download($file, $name) -> deleteFileAfterSend(true);

        }
    }
}
