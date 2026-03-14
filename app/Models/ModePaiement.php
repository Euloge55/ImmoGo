<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ModePaiement extends Model
{
    protected $primaryKey = 'id_mode_paiement';
    protected $fillable = ['nom_mode_paiement'];

    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'id_mode_paiement', 'id_mode_paiement');
    }
}