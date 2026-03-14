<?php
namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Administrateur extends Authenticatable
{
    use HasApiTokens;

    protected $primaryKey = 'id_admin';

    protected $fillable = [
        'id_agence',
        'nom_admin',
        'prenom_admin',
        'email',
        'mot_de_passe',
        'est_principal',
    ];

    protected $hidden = ['mot_de_passe'];

    public function agence()
    {
        return $this->belongsTo(Agence::class, 'id_agence', 'id_agence');
    }

    public function biens()
    {
        return $this->hasMany(Bien::class, 'id_admin', 'id_admin');
    }
}