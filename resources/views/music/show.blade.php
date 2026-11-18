@extends('layouts.app')

@section('title', $track->title)

@section('content')
    <h1>{{ $track->title }}</h1>
    <p><b>Исполнитель:</b> {{ $track->artist->name }}</p>
    <p><b>Альбом:</b> {{ $track->album->title ?? '—' }}</p>
    <p><b>Год:</b> {{ $track->year ?? '—' }}</p>
    <p><b>Жанры:</b> {{ $track->genres->pluck('name')->join(', ') ?: '—' }}</p>

    <h2>Комментарии к треку</h2>
    @forelse($track->comments as $comment)
        <div class="form-group">
            <b>{{ $comment->author ?? 'Аноним' }}:</b> {{ $comment->body }}
        </div>
    @empty
        <p>Комментариев нет.</p>
    @endforelse

    <p><a href="{{ route('music.index') }}">← Назад к списку</a></p>
@endsection