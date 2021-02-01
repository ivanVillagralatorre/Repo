<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tablaObras extends Model
{
    use HasFactory;
    protected $table = "obras";
    protected $guarded = [];
    public $timestamps = false;
}
