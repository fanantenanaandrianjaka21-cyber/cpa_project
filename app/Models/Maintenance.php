<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_ticket',
        'id_materiel',
        'date_debut',
        'date_fin',

    ];
}
