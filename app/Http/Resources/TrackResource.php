<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'year'     => $this->year,
            'duration' => $this->duration,
            'artist'   => $this->whenLoaded('artist', fn () => [
                'id'   => $this->artist->id,
                'name' => $this->artist->name,
            ]),
            'album'    => $this->whenLoaded('album', fn () => $this->album ? [
                'id'    => $this->album->id,
                'title' => $this->album->title,
            ] : null),
            'genres'   => $this->whenLoaded('genres', fn () =>
                $this->genres->map(fn ($g) => ['id' => $g->id, 'name' => $g->name])
            ),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}