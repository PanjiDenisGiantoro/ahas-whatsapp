<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blast extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'sender',
        'campaign_id',
        'receiver',
        'message',
        'type',
        'status',
        'id_contact'
    ];

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('D M Y H:i:s');
    }
    public function nomers(){
        return $this->hasOne(Contact::class,'id','id_contact');
        }
    public function campaings(){
        return $this->hasOne(Campaign::class,'id','campaign_id');
        }
}
