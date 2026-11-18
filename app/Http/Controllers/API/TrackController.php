<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrackRequest;
use App\Http\Resources\TrackResource;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TrackController extends Controller
{
    public function index(Request $request)
    {
        $query = Track::with(['artist', 'album', 'genres']);

        if ($request->filled('genre')) {
            $query->inGenre($request->string('genre'));
        }
        if ($request->filled('artist_id')) {
            $query->byArtist($request->integer('artist_id'));
        }
        if ($request->filled('year')) {
            $query->releasedAfter($request->integer('year'));
        }
        if ($request->filled('q')) {
            $query->search($request->string('q'));
        }

        return TrackResource::collection($query->paginate(20));
    }

    public function show(Track $track)
    {
        $track->load(['artist', 'album', 'genres', 'comments']);
        return new TrackResource($track);
    }

    public function store(TrackRequest $request)
    {
        $track = Track::create($request->validated());
        if ($request->filled('genres')) {
            $track->genres()->sync($request->input('genres'));
        }
        return (new TrackResource($track->load(['artist', 'album', 'genres'])))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(TrackRequest $request, Track $track)
    {
        $track->update($request->validated());
        if ($request->has('genres')) {
            $track->genres()->sync($request->input('genres'));
        }
        return new TrackResource($track->load(['artist', 'album', 'genres']));
    }

    public function destroy(Track $track)
    {
        $track->delete();
        return response()->json(['message' => 'Track deleted'], Response::HTTP_OK);
    }
}