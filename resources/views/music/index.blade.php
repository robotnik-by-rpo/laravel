@extends('layouts.app')

@section('title', 'Все треки')

@section('content')
    <h1>Список всех композиций</h1>

    @if(count($tracks) > 0)
        <table>
            <thead>
                <tr>
                    <th>Исполнитель</th>
                    <th>Название</th>
                    <th>Жанр</th>
                    <th>Год</th>
                    <th>Файл</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tracks as $track)
                    <tr>
                        <td>{{ $track['artist'] ?? '-' }}</td>
                        <td>{{ $track['title'] ?? '-' }}</td>
                        <td>{{ $track['genre'] ?? '-' }}</td>
                        <td>{{ $track['year'] ?? '-' }}</td>
                        <td>{{ $track['_file'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Пока нет сохраненных треков.</p>
    @endif
@endsection