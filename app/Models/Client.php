<?php
namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use HasApiTokens;

    protected $primaryKey = 'id_client';

    protected $fillable = [
        'nom_client',
        'prenom_client',
        'email',
        'tel_client',
        'mot_de_passe',
    ];

    protected $hidden = ['mot_de_passe'];

    public function contrats()
    {
        return $this->hasMany(Contrat::class, 'id_client', 'id_client');
    }

    public function favoris()
    {
        return $this->hasMany(Favoris::class, 'id_client', 'id_client');
    }
}