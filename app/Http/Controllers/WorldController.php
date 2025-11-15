<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorldRequest;
use App\Http\Resources\WorldMapResource;
use App\Http\Resources\WorldResource;
use App\Models\World;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class WorldController extends Controller
{
    public function index()
    {
        return World::all();
    }

    public function store(StoreWorldRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        $world = $user->worlds()->create($data)->loadCount('entities');

        return response()->json([
            'message' => 'World created',
            'world' => WorldResource::make($world)
        ], 201);
    }

    public function indexByUserId(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'worlds' => WorldResource::collection($user->worlds()->withCount('entities')->get())
        ]);
    }

    public function show(World $world)
    {
        return new WorldMapResource($world->load('entities', 'relationships'));
    }

    public function update(StoreWorldRequest $request, World $world)
    {
        Gate::authorize('update', $world);
        $data = $request->validated();
        $world->update($data);

        return $world;
    }

    public function destroy(World $world)
    {
        Gate::authorize('destroy', $world);
        $world->delete();

        return response()->json();
    }
}
