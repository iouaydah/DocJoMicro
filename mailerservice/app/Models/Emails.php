<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{

    protected $fillable = [
        'from',
        'to',
        'subject',
        'body'
        
    ];
}