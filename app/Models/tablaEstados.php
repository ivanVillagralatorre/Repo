<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tablaEstados extends Model
{
    use HasFactory;
    protected $table = "estados";
    protected $guarded = [];
    public $timestamps = false;
}
