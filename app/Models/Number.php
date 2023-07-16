<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','body','webhook','status','messages_sent'];

    protected static function booted(): void
    {
        static::addGlobalScope(new \App\Models\Scopes\GetLatestDataScope);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function autoreplies(){
        return $this->hasMany(Autoreply::class,'device','body');
    }
}
