<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketStatusConfig extends Model
{
    protected $table = 'ticket_statuses';
    protected $primaryKey = 'code';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['code', 'label', 'color'];
}
