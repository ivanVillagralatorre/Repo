<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tablaTiposObra extends Model
{
    use HasFactory;
    protected $table = "tipos_obra";
    protected $guarded = [];
    public $timestamps = false;
}
