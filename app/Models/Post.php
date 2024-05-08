<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'worker_id',
        'content',
        'price',
        'status',
        'rejected_reason',
    ];

    public function worker(){
        return $this->belongsTo(worker::class);
    }
}
