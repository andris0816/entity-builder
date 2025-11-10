<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRelationshipRequest;
use App\Http\Resources\RelationshipResource;
use App\Models\Relationship;
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

    public function update(StoreRelationshipRequest $request, Relationship $relationship)
    {
        Gate::authorize('update', $relationship);
        $data = $request->validated();

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
