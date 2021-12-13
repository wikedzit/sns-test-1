<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flipgrid extends Model
{
    use HasFactory;
    protected $fillable = ['grid_id', 'topic_id'];
}
