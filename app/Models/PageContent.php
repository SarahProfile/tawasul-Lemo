<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $fillable = [
        'page',
        'section', 
        'key',
        'value',
        'type'
    ];

    public static function getContent($page, $section, $key, $default = '')
    {
        $content = self::where('page', $page)
                      ->where('section', $section)
                      ->where('key', $key)
                      ->first();
        
        return $content ? $content->value : $default;
    }

    public static function setContent($page, $section, $key, $value, $type = 'text')
    {
        return self::updateOrCreate(
            ['page' => $page, 'section' => $section, 'key' => $key],
            ['value' => $value, 'type' => $type]
        );
    }
}
