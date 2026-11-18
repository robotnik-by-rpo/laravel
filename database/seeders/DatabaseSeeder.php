<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Track;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $rock  = Genre::create(['name' => 'Rock', 'slug' => 'rock']);
        $pop   = Genre::create(['name' => 'Pop', 'slug' => 'pop']);
        $jazz  = Genre::create(['name' => 'Jazz', 'slug' => 'jazz']);
        $indie = Genre::create(['name' => 'Indie', 'slug' => 'indie']);
        $industrial = Genre::create(['name' => 'Industrial', 'slug' => 'industrial']);

        $queen = Artist::create(['name' => 'Queen', 'country' => 'UK']);
        $miles = Artist::create(['name' => 'Miles Davis', 'country' => 'USA']);
        $death = Artist::create(['name' => 'Death Grips', 'country' => 'USA']);

        $album = Album::create([
            'artist_id' => $queen->id,
            'title'     => 'A Night at the Opera',
            'year'      => 1975,
        ]);

        $moneyStore = Album::create([
            'artist_id' => $death->id,
            'title'     => 'Money store',
            'year'      => 2012,
        ]);

        $track1 = Track::create([
            'artist_id' => $queen->id,
            'album_id'  => $album->id,
            'title'     => 'Bohemian Rhapsody',
            'year'      => 1975,
            'duration'  => 355,
        ]);
        $track1->genres()->attach([$rock->id, $pop->id]);

        $track2 = Track::create([
            'artist_id' => $miles->id,
            'title'     => 'So What',
            'year'      => 1959,
            'duration'  => 545,
        ]);
        $track2->genres()->attach($jazz->id);

        $track3 = Track::create([
            'artist_id' => $death->id,
            'album_id'  => $moneyStore->id,
            'title'     => 'Hacker',
            'year'      => 2012,
            'duration'  => 261,
        ]);

        $track3->genres()->attach($industrial->id);

        $moneyStore->comments()->create(['author' => 'Carol', 'body' => 'too experimental for me']);

        $track1->comments()->create(['author' => 'Alice', 'body' => 'cool!']);
        $album->comments()->create(['author' => 'Bob', 'body' => 'classic']);
    }
}