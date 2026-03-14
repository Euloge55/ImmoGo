<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    protected $primaryKey = 'id_ville';
    protected $fillable = ['id_departement', 'nom_ville'];

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'id_departement', 'id_departement');
    }

    public function quartiers()
    {
        return $this->hasMany(Quartier::class, 'id_ville', 'id_ville');
    }

    public function biens()
    {
        return $this->hasMany(Bien::class, 'id_ville', 'id_ville');
    }
}