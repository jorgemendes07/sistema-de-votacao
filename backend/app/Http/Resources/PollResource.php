<?php

namespace App\Http\Resources;

use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PollResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user = $request->user('sanctum');

        return [
            'id' => $this->id,
            'title' => $this->title,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'voted_option_id' => $user
                ? Vote::where('user_id', $user->id)->where('poll_id', $this->id)->value('poll_option_id')
                : null,
            'options' => PollOptionResource::collection($this->whenLoaded('options')),
        ];
    }
}
