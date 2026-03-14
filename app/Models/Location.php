<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $primaryKey = 'id_location';
    protected $fillable = [
        'id_contrat', 'montant_total_location',
        'date_reserv_location', 'date_limite_solde_location'
    ];

    public function contrat()
    {
        return $this->belongsTo(Contrat::class, 'id_contrat', 'id_contrat');
    }
}