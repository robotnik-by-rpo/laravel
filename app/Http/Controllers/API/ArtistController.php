<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArtistResource;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArtistController extends Controller
{
    public function index(Request $request)
    {
        $query = Artist::with('tracks');

        if ($request->filled('country')) {
            $query->fromCountry($request->string('country'));
        }
        if ($request->filled('q')) {
            $query->search($request->string('q'));
        }

        return ArtistResource::collection($query->paginate(20));
    }

    public function show(Artist $artist)
    {
        $artist->load(['tracks.genres', 'albums']);
        return new ArtistResource($artist);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255|unique:artists,name',
            'country' => 'nullable|string|max:100',
            'bio'     => 'nullable|string',
        ]);
        $artist = Artist::create($data);
        return (new ArtistResource($artist))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(Request $request, Artist $artist)
    {
        $data = $request->validate([
            'name'    => 'sometimes|string|max:255|unique:artists,name,' . $artist->id,
            'country' => 'nullable|string|max:100',
            'bio'     => 'nullable|string',
        ]);
        $artist->update($data);
        return new ArtistResource($artist);
    }

    public function destroy(Artist $artist)
    {
        $artist->delete();
        return response()->json(['message' => 'Artist deleted']);
    }
}