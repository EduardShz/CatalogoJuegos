<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\CreatorRequest;
use Illuminate\Http\Request;
use App\Models\Creator;
use Illuminate\Http\JsonResponse;

// NO olvidar que todo lo que se mande al front debe de ser envíado en formato 'json'
// Para el store y update se utilizó un Request --> 'CreatorRequest' para mantener el código más sencillo y limpio

class CreatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $creator = Creator::query()
            ->when($request->search, function (Builder $query, string $search) {
                return $query->where('name', 'LIKE', "%{$search}%");
            })
            ->get();

        return response()->json([
            'data' => $creator,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatorRequest $request)
    {
        $creator = Creator::create($request->validated());

        return response()->json([
            'success' => true,
            'creator' => $creator,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Creator $creator)
    {
        return response()->json([
            'data' => $creator,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreatorRequest $request, $id)
    {
        $creator = Creator::find($id);
        $creator->update($request->validated());

        return response()->json([
            'success' => true,
            'creator' => $creator,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyC(Creator $creator)
    {
        $creator->delete();
        
        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
