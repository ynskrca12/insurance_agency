<?php

namespace App\Models;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory, BelongsToTenant;

    // protected $fillable = [
    //     'key',
    //     'value',
    //     'type',
    //     'description',
    // ];

    protected $guarded = [];

    /**
     * Ayar değerini getir
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();

        return $setting ? $setting->value : $default;
    }

    /**
     * Ayar değerini kaydet
     */
    public static function set($key, $value, $type = 'string')
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );
    }

    /**
     * Boolean değer mi kontrol et
     */
    public function getBooleanValueAttribute()
    {
        return filter_var($this->value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Integer değer mi kontrol et
     */
    public function getIntegerValueAttribute()
    {
        return (int) $this->value;
    }
}
