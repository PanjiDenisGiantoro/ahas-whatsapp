<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'templateName', 'templateMessage','templateType','user_id','templateGoodBye'
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new \App\Models\Scopes\GetLatestDataScope);
    }
}
