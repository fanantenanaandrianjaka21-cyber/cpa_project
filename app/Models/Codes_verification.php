<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Codes_verification extends Model
{
    protected $table = 'codes_verifications';

    protected $fillable = [
        'utilisateur_id',
        'code',
        'expire_le',
    ];

    public $timestamps = true;
        /**
     * Vérifie si le code est expiré.
     */
    public function estExpire()
    {
        return now()->greaterThan($this->expire_le);
    }
}
