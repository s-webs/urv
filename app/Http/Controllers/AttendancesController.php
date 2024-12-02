<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendancesController extends Controller
{
    public function test()
    {

    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();

        // Проверяем, не сделал ли пользователь уже отметку прихода
        $attendance = Attendance::query()->where('user_id', $user->id)
            ->whereNull('check_out_time')
            ->first();

        if ($attendance) {
            return response()->json(['error' => 'Вы уже отметили приход, отметьте уход перед новой отметкой.'], 400);
        }

        Attendance::query()->create([
            'user_id' => $user->id,
            'check_in_time' => now(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json(['message' => 'Приход успешно отмечен.']);
    }

    public function checkOut(Request $request)
    {
        $user = Auth::user();

        // Находим активную запись посещения
        $attendance = Attendance::query()->where('user_id', $user->id)
            ->whereNull('check_out_time')
            ->first();

        if (!$attendance) {
            return response()->json(['error' => 'Нет активной записи для отметки ухода.'], 400);
        }

        $attendance->update([
            'check_out_time' => now(),
        ]);

        return response()->json(['message' => 'Уход успешно отмечен.']);
    }
}
