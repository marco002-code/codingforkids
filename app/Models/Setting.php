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

