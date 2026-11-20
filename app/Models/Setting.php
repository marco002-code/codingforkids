<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
        'label',
        'description',
    ];

    /**
     * Get setting value by key with fallback.
     */
    public static function get(string $key, $default = null)
    {
        $value = Cache::remember("setting_{$key}", 3600, function () use ($key) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : null;
        });

        return $value ?? $default;
    }

    /**
     * Parse a time range string (e.g. "07:30 – 10:00 WIB" or "07.30 - 08.35")
     * and calculate the duration in minutes.
     */
    public static function calculateMinutes(?string $timeRange): int
    {
        if (empty($timeRange)) {
            return 0;
        }

        // Match two time formats: HH:MM or HH.MM separated by dash / en-dash / to
        if (preg_match('/(\d{1,2})[:.](\d{2})\s*(?:[-–—]|s\/d|to)\s*(\d{1,2})[:.](\d{2})/iu', $timeRange, $matches)) {
            $startMinutes = ((int) $matches[1]) * 60 + ((int) $matches[2]);
            $endMinutes = ((int) $matches[3]) * 60 + ((int) $matches[4]);

            if ($endMinutes >= $startMinutes) {
                return $endMinutes - $startMinutes;
            }
        }

        return 0;
    }

    /**
     * Format a calculated duration into friendly Indonesian text (e.g. "2.5 Jam (150 Menit)" or "65 Menit").
     */
    public static function calculateDuration(?string $timeRange): string
    {
        $minutes = static::calculateMinutes($timeRange);
        if ($minutes <= 0) {
            return '';
        }

        if ($minutes % 60 === 0) {
            $hours = $minutes / 60;
            return "{$hours} Jam ({$minutes} Menit)";
        }

        $hours = round($minutes / 60, 1);
        if ($minutes >= 60) {
            $h = floor($minutes / 60);
            $m = $minutes % 60;
            return "{$hours} Jam ({$minutes} Menit)";
        }

        return "{$minutes} Menit";
    }

    /**
     * Format duration into short text (e.g. "2.5 Jam" or "45 Mnt").
     */
    public static function calculateDurationShort(?string $timeRange): string
    {
        $minutes = static::calculateMinutes($timeRange);
        if ($minutes <= 0) {
            return '';
        }

        if ($minutes % 60 === 0) {
            $hours = $minutes / 60;
            return "{$hours} Jam";
        }

        if ($minutes >= 60) {
            $hours = round($minutes / 60, 1);
            return "{$hours} Jam";
        }

        return "{$minutes} Menit";
    }

    /**
     * Sum the total duration in minutes of a rundown array.
     */
    public static function calculateRundownTotalMinutes(array $rundown): int
    {
        $total = 0;
        foreach ($rundown as $item) {
            // Check if duration has explicit minutes (e.g. "65 Menit")
            if (!empty($item['duration']) && preg_match('/(\d+)\s*menit/i', $item['duration'], $m)) {
                $total += (int) $m[1];
            } elseif (!empty($item['time'])) {
                $total += static::calculateMinutes($item['time']);
            }
        }
        return $total;
    }

    /**
     * Default 5-stack rundown structure for a session.
     */
    public static function defaultRundown(int $session = 1): array
    {
        if ($session === 1) {
            return [
                [
                    'time' => '07:00 – 07:30',
                    'title' => 'Registrasi Ulang & Pengambilan Name Tag',
                    'description' => 'Check-in scan QR Code E-Ticket atau sebutkan 5 huruf kode registrasi, pembagian Name Tag dan persiapan komputer di Lab TIK 1 & Lab TIK 3.',
                    'duration' => '30 Menit',
                    'type' => 'default',
                ],
                [
                    'time' => '07:30 – 08:35',
                    'title' => 'Modul 1: Coding & Praktik Membuat Game 🎮',
                    'description' => 'Logika sekuensial, algoritma visual Scratch, dan merakit game interaktif perdana.',
                    'duration' => '65 Menit',
                    'type' => 'blue',
                ],
                [
                    'time' => '08:35 – 08:50',
                    'title' => 'Istirahat (Snack Time & Fun Quiz) 🍪',
                    'description' => 'Waktu istirahat snack lezat 15 menit, kuis seru berhadiah, dan networking teman baru.',
                    'duration' => '15 Menit Istirahat',
                    'type' => 'amber',
                ],
                [
                    'time' => '08:50 – 09:30',
                    'title' => 'Modul 2: Pemanfaatan A.I. untuk Belajar 🤖',
                    'description' => 'Eksplorasi kecerdasan buatan ramah anak, prompt cilik, dan praktik A.I. sebagai sahabat belajar pintar.',
                    'duration' => '40 Menit',
                    'type' => 'purple',
                ],
                [
                    'time' => '09:30 – 10:00',
                    'title' => 'Modul 3: Keamanan Digital + Showcase & Sertifikat 🎓',
                    'description' => 'Cyber safety Google Interland, pameran hasil karya game, dan penyerahan sertifikat peserta.',
                    'duration' => '30 Menit',
                    'type' => 'emerald',
                ],
            ];
        }

        return [
            [
                'time' => '10:00 – 10:30',
                'title' => 'Registrasi Ulang & Pengambilan Name Tag',
                'description' => 'Check-in scan QR Code E-Ticket atau sebutkan 5 huruf kode registrasi, pembagian Name Tag dan persiapan komputer di Lab TIK 1 & Lab TIK 3.',
                'duration' => '30 Menit',
                'type' => 'default',
            ],
            [
                'time' => '10:30 – 11:05',
                'title' => 'Modul 1: Coding & Praktik Membuat Game 🎮',
                'description' => 'Logika sekuensial, algoritma visual Scratch, dan merakit game interaktif perdana.',
                'duration' => '35 Menit',
                'type' => 'blue',
            ],
            [
                'time' => '11:05 – 11:20',
                'title' => 'Istirahat (Snack Time & Fun Quiz) 🍪',
                'description' => 'Waktu istirahat snack lezat 15 menit, ice breaking seru berhadiah, dan networking teman baru.',
                'duration' => '15 Menit Istirahat',
                'type' => 'amber',
            ],
            [
                'time' => '11:20 – 11:45',
                'title' => 'Modul 2: Pemanfaatan A.I. untuk Belajar 🤖',
                'description' => 'Eksplorasi kecerdasan buatan ramah anak, prompt cilik, dan praktik A.I. sebagai sahabat belajar pintar.',
                'duration' => '25 Menit',
                'type' => 'purple',
            ],
            [
                'time' => '11:45 – 12:00',
                'title' => 'Modul 3: Keamanan Digital + Showcase & Sertifikat 🎓',
                'description' => 'Cyber safety Google Interland, pameran hasil karya game, dan penyerahan sertifikat peserta.',
                'duration' => '15 Menit',
                'type' => 'emerald',
            ],
        ];
    }

    /**
     * Get rundown stack for a session with fallback to default.
     */
    public static function getRundown(int $session = 1): array
    {
        $key = "session_{$session}_rundown";
        $json = static::get($key);
        if (!empty($json)) {
            $decoded = json_decode($json, true);
            if (is_array($decoded) && count($decoded) > 0) {
                return $decoded;
            }
        }
        return static::defaultRundown($session);
    }

    /**
     * Set or update setting value by key.
     */
    public static function set(string $key, $value, ?string $group = null, ?string $label = null, ?string $description = null)
    {
        $data = ['value' => $value];
        if ($group !== null) $data['group'] = $group;
        if ($label !== null) $data['label'] = $label;
        if ($description !== null) $data['description'] = $description;

        $setting = static::updateOrCreate(['key' => $key], $data);
        Cache::forget("setting_{$key}");

        return $setting;
    }
}

