<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TypeBien;
use Illuminate\Http\Request;

class TypeBienController extends Controller
{
    public function index()
    {
        return response()->json(TypeBien::all());
    }

    public function store(Request $request)
    {
        $request->validate(['libelle' => 'required|string']);
        $type = TypeBien::create($request->all());
        return response()->json([
            'message' => 'Type créé avec succès',
            'type'    => $type
        ], 201);
    }

    public function destroy($id)
    {
        TypeBien::where('id_typebien', $id)->firstOrFail()->delete();
        return response()->json(['message' => 'Type supprimé']);
    }
}