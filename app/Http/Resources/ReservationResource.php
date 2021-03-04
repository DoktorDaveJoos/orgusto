<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'start' => $this->start,
            'persons' => $this->persons,
            'duration' => $this->duration,
            'tables' => TableResource::collection($this->tables),
            'name' => $this->name,
            'email' => $this->email,
            'color' => $this->color,
            'notice' => $this->notice,
            'phone_number' => $this->phone_number,
            'user' => new UserResource($this->user),
            'done' => $this->done,
        ];
    }
}
