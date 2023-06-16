<?php

namespace App\Http\Resources;

use App\Models\Message;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAndMessageLatestResource extends JsonResource
{
    public function toArray($request)
    {
        // $message = $this->latestMessage($this->whenLoaded("messages"), $this->whenLoaded("messagesTo"));
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            // "message" => $message->count() ? new MessageResource($message) : null
            "message" => new MessageResource($this->latestMessage())
        ];
    }
}
