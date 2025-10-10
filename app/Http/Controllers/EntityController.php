<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    public function index()
    {
        return Entity::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'desc' => ['required'],
            'type' => ['required'],
            'world_id' => ['required', 'integer'],
        ]);

        return Entity::create($data);
    }

    public function show(Entity $entity)
    {
        return $entity;
    }

    public function update(Request $request, Entity $entity)
    {
        $data = $request->validate([
            'name' => ['required'],
            'desc' => ['required'],
            'type' => ['required'],
            'world_id' => ['required', 'integer'],
        ]);

        $entity->update($data);

        return $entity;
    }

    public function destroy(Entity $entity)
    {
        $entity->delete();

        return response()->json();
    }
}
