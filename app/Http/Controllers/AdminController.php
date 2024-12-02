<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard()
    {

        $attendances = Attendance::query()
            ->with('user')
            ->get()
            ->map(function ($attendance) {
                return [
                    'id' => $attendance->id,
                    'user' => [
                        'id' => $attendance->user->id,
                        'name' => $attendance->user->name,
                    ],
                    'check_in_time' => $attendance->check_in_time ? $attendance->check_in_time->format('d.m.Y H:i:s') : null,
                    'check_out_time' => $attendance->check_out_time ? $attendance->check_out_time->format('d.m.Y H:i:s') : null,
                    'latitude' => $attendance->latitude,
                    'longitude' => $attendance->longitude,
                ];
            });

        return Inertia::render('Admin/Dashboard', compact('attendances'));
    }
}
