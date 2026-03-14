<?php
namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SuperAdmin extends Authenticatable
{
    use HasApiTokens;

    protected $primaryKey = 'id_superadmin';

    protected $fillable = [
        'nom_superadmin',
        'email',
        'mot_de_passe',
    ];

    protected $hidden = ['mot_de_passe'];

    public function agences()
    {
        return $this->hasMany(Agence::class, 'id_superadmin', 'id_superadmin');
    }
}