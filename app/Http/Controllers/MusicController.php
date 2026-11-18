<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrackRequest;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Track;
use App\Models\Album;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    public function index(Request $request)
    {
        $query = Track::with(['artist', 'genres'])->latest();

        if ($request->filled('q')) {
            $query->search($request->string('q'));
        }
        if ($request->filled('genre')) {
            $query->inGenre($request->string('genre'));
        }
        if ($request->boolean('with_trashed')) {
            $query->withTrashed();
        }

        $tracks = $query->paginate(10)->withQueryString();
        $genres = Genre::orderBy('name')->get();

        return view('music.index', compact('tracks', 'genres'));
    }

    public function show(Track $track)
    {
        $track->load(['artist', 'album', 'genres', 'comments']);
        return view('music.show', compact('track'));
    }

    public function create()
    {
        return view('music.create', [
            'artists' => Artist::orderBy('name')->get(),
            'genres'  => Genre::orderBy('name')->get(),
        ]);
    }

    public function store(TrackRequest $request)
    {
        $artist = Artist::firstOrCreate([
        'name' => $request->input('artist_name')
        ]);

        $albumId = null;
        if ($request->filled('album_title')) {
            $album = Album::firstOrCreate([
                'title'     => $request->input('album_title'),
                'artist_id' => $artist->id,
            ]);
            $albumId = $album->id;
        }

        $track = Track::create([
            'artist_id' => $artist->id,
            'album_id'  => $albumId,
            'title'     => $request->input('title'),
            'year'      => $request->input('year'),
            'duration'  => $request->input('duration'),
        ]);

        if ($request->filled('genre_id')) {
            $track->genres()->sync([$request->input('genre_id')]);
        }

        return redirect()->route('music.index')->with('success', 'Трек создан.');
    }

    public function edit(Track $track)
    {
        return view('music.edit', [
            'track'   => $track->load('genres'),
            'artists' => Artist::orderBy('name')->get(),
            'genres'  => Genre::orderBy('name')->get(),
            'albums'  => Album::orderBy('title')->get(),
        ]);
    }

    public function update(TrackRequest $request, Track $track)
    {
        $artist = Artist::firstOrCreate([
        'name' => $request->input('artist_name')
        ]);

        $albumId = null;
        if ($request->filled('album_title')) {
            $album = Album::firstOrCreate([
                'title'     => $request->input('album_title'),
                'artist_id' => $artist->id,
            ]);
            $albumId = $album->id;
        }

        $track->update([
            'artist_id' => $artist->id,
            'album_id'  => $albumId,
            'title'     => $request->input('title'),
            'year'      => $request->input('year'),
            'duration'  => $request->input('duration'),
        ]);

        if ($request->filled('genre_id')) {
            $track->genres()->sync([$request->input('genre_id')]);
        } else {
            $track->genres()->sync([]);
        }

        return redirect()->route('music.index')->with('success', 'Трек обновлён.');
    }

    public function destroy(Track $track)
    {
        $track->delete();
        return redirect()->route('music.index')->with('success', 'Трек перемещён в корзину.');
    }

    public function restore(int $id)
    {
        Track::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('music.index')->with('success', 'Трек восстановлен.');
    }

    public function forceDelete(int $id)
    {
        Track::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('music.index')->with('success', 'Трек удалён окончательно.');
    }
}