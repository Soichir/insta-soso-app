<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function blocker(){
        return $this->belongsTo(User::class, 'blocker_id')->withTrashed();
    }

    public function blocking(){
        return $this->belongsTo(User::class, 'blocking_id')->withTrashed();
    }
}
