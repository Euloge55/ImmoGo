<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quartier extends Model
{
    protected $primaryKey = 'id_quartier';
    protected $fillable = ['id_ville', 'nom_quartier'];

    public function ville()
    {
        return $this->belongsTo(Ville::class, 'id_ville', 'id_ville');
    }

    public function biens()
    {
        return $this->hasMany(Bien::class, 'id_quartier', 'id_quartier');
    }
}