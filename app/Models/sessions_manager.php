<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sessions_manager extends Model
{
    use HasFactory;

    protected $table = 'sessions_manager';
    protected $primarykey = 'sess_id';

    public $timestamps = false;

    public function session_owner()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}