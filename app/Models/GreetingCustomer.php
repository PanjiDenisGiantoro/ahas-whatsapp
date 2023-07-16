<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class GreetingCustomer extends Model
{
    use HasFactory;

    protected $table = 'greeting_costumers';

    protected static function booted(): void
    {
        static::addGlobalScope(new \App\Models\Scopes\GetLatestDataScope);
    }

    protected $fillable = [
        'name',
        'number',
        'jenis_motor',
        'masuk',
        'image_greeting',
        'image_bye',
        'idtemplate',
        'status',
        'sender'
    ];
    public function templates()
    {
        return $this->hasOne(TemplateMessage::class, 'id', 'idtemplate');
    }

//    getattributetextname

}
