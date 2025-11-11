<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntityRequest;
use App\Models\Entity;
use App\Models\World;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EntityController extends Controller
{
    public function index()
    {
        return Entity::all();
    }

    public function store(StoreEntityRequest $request)
    {
        $data = $request->validated();

        $world = World::find($data['world_id']);
        Gate::authorize('createEntity', $world);

        $entity = Entity::create($data);

        return response()->json($entity, 201);
    }

    public function show(Entity $entity)
    {
        return $entity;
    }

    public function update(Request $request, Entity $entity)
    {
        Gate::authorize('update', $entity);

        $data = $request->validate([
            'name' => ['required'],
            'desc' => ['required'],
            'type' => ['required'],
        ]);

        $entity->update($data);

        return $entity;
    }

    public function destroy(Entity $entity)
    {
        Gate::authorize('delete', $entity);

        $entity->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
