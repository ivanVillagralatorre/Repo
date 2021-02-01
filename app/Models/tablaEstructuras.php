<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tablaEstructuras extends Model
{
    use HasFactory;
    protected $table = "estructuras";
    protected $guarded = [];
    public $timestamps = false;
}
