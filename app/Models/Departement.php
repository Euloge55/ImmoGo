<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $primaryKey = 'id_departement';
    protected $fillable = ['nom_departement'];

    public function villes()
    {
        return $this->hasMany(Ville::class, 'id_departement', 'id_departement');
    }

    public function biens()
    {
        return $this->hasMany(Bien::class, 'id_departement', 'id_departement');
    }
}