<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
//    guarded
    protected $guarded = [];
    protected $table = 'contacts';

    protected static function booted(): void
    {
        static::addGlobalScope(new \App\Models\Scopes\GetLatestDataScope);
    }

    public function tag(){
        return $this->belongsTo(Tag::class);
    }
}
