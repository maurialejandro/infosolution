<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Web extends Model
{
    use HasFactory;
    protected $table = 'webs';

    public function user(){
        return $this->belongsTo('App/user', 'user_id');
    }
}
