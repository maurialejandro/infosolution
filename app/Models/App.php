<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    use HasFactory;
    protected $table = 'apps';

    public function user(){
        return $this->belongsTo('App/App', 'user_id');
    }
}
