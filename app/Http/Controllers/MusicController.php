<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MusicController extends Controller
{
    public function create()
    {
        return view('music.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'artist' => 'required|string|max:255',
            'title'  => 'required|string|max:255',
            'genre'  => 'required|string|max:100',
            'year'   => 'required|integer|min:1900|max:' . date('Y'),
        ], [
            'artist.required' => 'Поле исполнитель обязательно.',
            'title.required'  => 'Поле название обязательно.',
            'year.integer'    => 'Год должен быть числом.',
        ]);

        $filename = 'music_' . uniqid() . '.json';


        Storage::put('music/' . $filename, json_encode($validated, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return redirect()->route('music.create')->with('success', 'Композиция успешно сохранена в файл: ' . $filename);
    }

    public function index()
    {
        $files = Storage::files('music');
        $tracks = [];

        foreach ($files as $file) {
            $content = Storage::get($file);
            $data = json_decode($content, true);
            if ($data) {
                $data['_file'] = basename($file);
                $tracks[] = $data;
            }
        }

        return view('music.index', compact('tracks'));
    }
}