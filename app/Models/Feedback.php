<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'user_id', 'title', 'description', 'category'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
