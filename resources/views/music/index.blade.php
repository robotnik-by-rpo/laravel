@extends('layouts.app')

@section('title', 'Все треки')

@section('content')
    <h1>Список всех композиций</h1>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('music.index') }}" class="form-group">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Поиск по названию">
        <select name="genre">
            <option value="">жанр</option>
            @foreach($genres as $g)
                <option value="{{ $g->slug }}" @selected(request('genre') === $g->slug)>{{ $g->name }}</option>
            @endforeach
        </select>
        <button type="submit">Фильтр</button>
        <a href="{{ route('music.index', ['with_trashed' => 1]) }}">Показать удалённые</a>
    </form>

    @if($tracks->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Исполнитель</th>
                    <th>Название</th>
                    <th>Альбом</th> {{-- Новый столбец --}}
                    <th>Жанры</th>
                    <th>Год</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tracks as $track)
                    <tr>
                        <td>{{ $track->id }}</td>
                        <td>{{ $track->artist->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('music.show', $track) }}">{{ $track->title }}</a>
                        </td>
                        <td>
                            @if($track->album)
                                <a href="{{ route('music.show', $track) }}" title="Перейти к треку и комментариям">
                                    {{ $track->album->title }}
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $track->genres->pluck('name')->join(', ') ?: '-' }}</td>
                        <td>{{ $track->year ?? '-' }}</td>
                        <td>
                            @if($track->trashed())
                                <form action="{{ route('music.restore', $track->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button>Восстановить</button>
                                </form>
                                <form action="{{ route('music.forceDelete', $track->id) }}" method="POST" style="display:inline"
                                      onsubmit="return confirm('Удалить навсегда?')">
                                    @csrf @method('DELETE')
                                    <button>Удалить окончательно</button>
                                </form>
                            @else
                                <a href="{{ route('music.edit', $track) }}">Изменить</a>
                                <form action="{{ route('music.destroy', $track) }}" method="POST" style="display:inline"
                                      onsubmit="return confirm('Удалить трек?')">
                                    @csrf @method('DELETE')
                                    <button>Удалить</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $tracks->links() }}
    @else
        <p>Пока нет сохранённых треков.</p>
    @endif
@endsection