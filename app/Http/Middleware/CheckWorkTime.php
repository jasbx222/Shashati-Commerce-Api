<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\WorkTime;
use Carbon\Carbon;

class CheckWorkTime
{
    protected function isWorkTimeOver(): bool
    {
        $workTime = WorkTime::first();

        if (!$workTime) {
            return false; // إذا ماكو سجل، نسمح بالوصول
        }

        $now = now();
        $start = Carbon::createFromTimeString($workTime->start_time);
        $end   = Carbon::createFromTimeString($workTime->end_time);

        if ($start->eq($end)) {
            // إذا الوقتين نفس الشيء، نعتبر الدوام منتهي
            return true;
        }

        if ($start->lt($end)) {
            // دوام نهاري: من الصباح للعصر
            $withinTime = $now->between($start, $end);
        } else {
            // دوام يمتد للساعة الثانية من اليوم التالي (ليلي)
            $withinTime = $now->gte($start) || $now->lte($end);
        }

        return !$withinTime; // true إذا خارج الدوام
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->isWorkTimeOver()) {
            return response()->json([
                'message' => 'لقد انتهى وقت الدوام الآن..'
            ], 403);
        }

        return $next($request);
    }
}
