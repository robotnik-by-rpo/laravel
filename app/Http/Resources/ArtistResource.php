<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArtistResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'country' => $this->country,
            'tracks'  => TrackResource::collection($this->whenLoaded('tracks')),
            'albums'  => $this->whenLoaded('albums', fn () =>
                $this->albums->map(fn ($a) => ['id' => $a->id, 'title' => $a->title, 'year' => $a->year])
            ),
        ];
    }
}