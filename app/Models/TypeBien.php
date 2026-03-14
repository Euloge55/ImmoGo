<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TypeBien extends Model
{
    protected $primaryKey = 'id_typebien';
    protected $fillable = ['libelle'];

    public function biens()
    {
        return $this->hasMany(Bien::class, 'id_typebien', 'id_typebien');
    }
}