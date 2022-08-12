<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessRegister extends Model
{
    use HasFactory;

    protected $fillable = ["path", "access", "name", "params"];
}