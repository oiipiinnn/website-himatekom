<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSetting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    // Helper method to get setting value
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    // Helper method to set setting value
    public static function set($key, $value)
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    // Get all settings as key-value array
    public static function getAll()
    {
        return static::pluck('value', 'key')->toArray();
    }

    // Get misi as array (split by |)
    public static function getMisi()
    {
        $misi = static::get('misi', '');
        return $misi ? explode('|', $misi) : [];
    }
}
