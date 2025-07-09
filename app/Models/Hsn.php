<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hsn extends Model
{
    protected $fillable = [
        'hsn_code',
        'description',
    ];
}
