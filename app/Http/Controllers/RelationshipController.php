<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRelationshipRequest;
use App\Http\Resources\RelationshipResource;
use App\Models\Relationship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RelationshipController extends Controller
{
    public function index()
    {
        return Relationship::all();
    }

    public function store(StoreRelationshipRequest $request)
    {
        $data = $request->validated();
        $relationship = Relationship::create($data);

        return response()->json(new RelationshipResource($relationship), 201);
    }

    public function show(Relationship $relationship)
    {
        return $relationship;
    }

    public function update(Request $request, Relationship $relationship)
    {
        $data = $request->validate([
            'entity_from' => ['required', 'integer'],
            'entity_to' => ['required', 'integer'],
            'type' => ['required'],
            'desc' => ['required'],
        ]);

        $relationship->update($data);

        return $relationship;
    }

    public function destroy(Relationship $relationship)
    {
        Gate::authorize('delete', $relationship);

        $relationship->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
