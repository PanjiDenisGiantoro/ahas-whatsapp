<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogCron extends Model
{
    use HasFactory;

    protected $table = 'log_crons';
    protected $guarded = [];
}
