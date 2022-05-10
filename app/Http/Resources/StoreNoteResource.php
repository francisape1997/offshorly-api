<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreNoteResource extends JsonResource
{
    public function toArray($request)
    {
        return
        [
            'id'    => $this->id,
            'title' => $this->title,
            'body'  => $this->body,
        ];
    }
}
