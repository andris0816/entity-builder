<?php

namespace App\Http\Controllers;

use App\Models\World;
use Auth;
use Illuminate\Http\Request;

class WorldController extends Controller
{
    public function index()
    {
        return World::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'desc' => ['required'],
        ]);

        $user = Auth::user();

        $world = $user->worlds()->create($data)->loadCount('entities');

        return response()->json([
            'message' => 'World created',
            'world' => $world
        ], 201);
    }

    public function indexByUserId(Request $request)
    {
        $user = $request->user();

        $worlds = $user->worlds()
            ->withCount('entities')
            ->get();

        return response()->json([
            'worlds' => $worlds
        ]);
    }

    public function show(World $world)
    {
        return $world;
    }

    public function update(Request $request, World $world)
    {
        $data = $request->validate([
            'name' => ['required'],
            'desc' => ['required'],
            'user_id' => ['required', 'integer'],
        ]);

        $world->update($data);

        return $world;
    }

    public function destroy(World $world)
    {
        $world->delete();

        return response()->json();
    }
}
