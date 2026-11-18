<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrackRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'artist_name' => 'required|string|max:255',
            'album_title' => 'nullable|string|max:255',
            'title'       => 'required|string|max:255',
            'year'        => 'nullable|integer|min:1900|max:' . date('Y'),
            'duration'    => 'nullable|integer|min:1',
            'genre_id'    => 'nullable|exists:genres,id',
        ];
    }
}