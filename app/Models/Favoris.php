<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Favoris extends Model
{
    protected $primaryKey = 'id_favoris';
    protected $fillable = ['id_client', 'id_bien'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client', 'id_client');
    }

    public function bien()
    {
        return $this->belongsTo(Bien::class, 'id_bien', 'id_bien');
    }
}