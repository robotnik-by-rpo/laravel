@extends('layouts.app')

@section('title', 'Редактировать трек')

@section('content')
    <h1>Редактировать: {{ $track->title }}</h1>

    <form action="{{ route('music.update', $track) }}" method="POST">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Исполнитель:</label>
            <input type="text" name="artist_name" value="{{ old('artist_name', $track->artist->name ?? '') }}" placeholder="Введите имя исполнителя">
            @error('artist_name')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Альбом:</label>
            <input type="text" name="album_title" value="{{ old('album_title', $track->album->title ?? '') }}" placeholder="Введите название альбома (или оставьте пустым)">
            @error('album_title')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Название трека:</label>
            <input type="text" name="title" value="{{ old('title', $track->title) }}">
            @error('title')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Жанр:</label>
            <select name="genre_id">
                <option value="">— выберите —</option>
                @foreach($genres as $g)
                    @php $currentGenreId = $track->genres->first()?->id; @endphp
                    <option value="{{ $g->id }}" @selected(old('genre_id', $currentGenreId) == $g->id)>
                        {{ $g->name }}
                    </option>
                @endforeach
            </select>
            @error('genre_id')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Год:</label>
            <input type="number" name="year" value="{{ old('year', $track->year) }}">
            @error('year')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Длительность (сек):</label>
            <input type="number" name="duration" value="{{ old('duration', $track->duration) }}">
            @error('duration')<div class="error">{{ $message }}</div>@enderror
        </div>

        <button type="submit">Обновить</button>
    </form>
@endsection