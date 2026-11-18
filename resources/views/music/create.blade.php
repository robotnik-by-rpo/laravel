@extends('layouts.app')

@section('title', 'Добавить трек')

@section('content')
    <h1>Добавить музыкальную композицию</h1>

    <form action="{{ route('music.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="artist_name">Исполнитель:</label>
            <input type="text" name="artist_name" id="artist_name" value="{{ old('artist_name') }}" placeholder="Введите имя исполнителя">
            @error('artist_name')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="album_title">Альбом:</label>
            <input type="text" name="album_title" id="album_title" value="{{ old('album_title') }}" placeholder="Введите название альбома">
            @error('album_title')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="title">Название трека:</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}">
            @error('title')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="genre_id">Жанр:</label>
            <select name="genre_id" id="genre_id">
                <option value="">Выберите</option>
                @foreach($genres as $g)
                    <option value="{{ $g->id }}" @selected(old('genre_id') == $g->id)>{{ $g->name }}</option>
                @endforeach
            </select>
            @error('genre_id')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="year">Год выпуска:</label>
            <input type="number" name="year" id="year" value="{{ old('year') }}">
            @error('year')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="duration">Длительность (сек):</label>
            <input type="number" name="duration" id="duration" value="{{ old('duration') }}">
            @error('duration')<div class="error">{{ $message }}</div>@enderror
        </div>

        <button type="submit">Сохранить</button>
    </form>
@endsection