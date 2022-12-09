<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UsageCounter;


class IncrementUses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $exam = $request->route('exam');
        $subject = $request->route('subject');
        $year = $request->route('year');
        $usageCounter = UsageCounter::firstOrCreate(["exam" => $exam, "subject" => $subject, "year" => $year]);
        $usageCounter->uses += 1;
        $usageCounter->save();
        return $next($request);
    }
}
