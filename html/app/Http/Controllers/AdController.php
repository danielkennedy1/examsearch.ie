<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class AdController extends Controller
{
    public function show(Request $request){
        $ip = $request -> ip();
        DB::insert("INSERT INTO `clicks` VALUES (DEFAULT, INET6_ATON('$ip'))");
        return redirect("https://www.themathstutor.ie/examsearch/");
    }
}
