@extends('layouts.app')

@section('title', 'Добавить трек')

@section('content')
    <h1>Добавить музыкальную композицию</h1>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('music.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="artist">Исполнитель:</label>
            <input type="text" name="artist" id="artist" value="{{ old('artist') }}">
            @error('artist')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="title">Название трека:</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}">
            @error('title')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="genre">Жанр:</label>
            <input type="text" name="genre" id="genre" value="{{ old('genre') }}">
            @error('genre')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="year">Год выпуска:</label>
            <input type="number" name="year" id="year" value="{{ old('year') }}">
            @error('year')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Сохранить</button>
    </form>
@endsection