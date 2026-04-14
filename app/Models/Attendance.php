<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Attendance extends Model
{
    use HasUuids;

    protected $table = 'attendances';

    protected $fillable = [
        'user_id',
        'user_type',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'durasi_jam',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'durasi_jam' => 'decimal:2',
    ];

    /**
     * Get the user (bisa UserDosen atau UserStaff)
     */
    public function user()
    {
        return $this->belongsTo(UserDosen::class, 'user_id')
            ->orWhere('user_type', 'dosen')
            ->union(\DB::table('users_staff')->whereColumn('id', 'attendances.user_id'));
    }

    /**
     * Scope untuk filter minggu ini
     */
    public function scopeThisWeek($query)
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        return $query->whereBetween('tanggal', [$startOfWeek, $endOfWeek]);
    }

    /**
     * Scope untuk filter hari kerja (Senin-Jumat)
     */
    public function scopeWorkDays($query)
    {
        return $query->whereNotIn(\DB::raw('DAYOFWEEK(tanggal)'), [1, 7]); // 1=Sunday, 7=Saturday
    }

    /**
     * Get total durasi minggu ini
     */
    public static function getTotalDurationThisWeek($userId)
    {
        return self::where('user_id', $userId)
            ->thisWeek()
            ->workDays()
            ->sum('durasi_jam');
    }

    /**
     * Get durasi per hari minggu ini (Senin-Jumat)
     */
    public static function getDurationByDayThisWeek($userId)
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $dayQuery = self::where('user_id', $userId)
            ->thisWeek()
            ->workDays()
            ->get()
            ->groupBy(function ($item) {
                $dayOfWeek = $item->tanggal->dayName;
                return match ($dayOfWeek) {
                    'Monday' => 'Senin',
                    'Tuesday' => 'Selasa',
                    'Wednesday' => 'Rabu',
                    'Thursday' => 'Kamis',
                    'Friday' => 'Jumat',
                    default => null,
                };
            });

        $result = [];
        foreach ($days as $day) {
            $result[$day] = $dayQuery->get($day)?->sum('durasi_jam') ?? 0;
        }

        return $result;
    }
}
