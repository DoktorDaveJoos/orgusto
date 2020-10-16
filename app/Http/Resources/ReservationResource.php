<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'id' => $this->id,
          'persons' => $this->persons,
          'duration' => $this->duration,
          'tables' => $this->tables,
          'name' => $this->name,
          'email'=> $this->email,
          'color' => $this->color,
          'notice' => $this->notice,
          'phone_number' => $this->phone_number,
          'user' => new UserResource($this->user)
        ];
    }
}
