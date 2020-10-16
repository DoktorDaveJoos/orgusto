<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'table_count' => $this->table_count,
            'contact_email' => $this->contact_email,
            'owner' => $this->owner,
            'street' => $this->street,
            'zip_code' => $this->zip_code,
            'street_number' => $this->street_number,
            'city' => $this->city,
            'default_table_seats' => $this->default_table_seats,
            'seat_reservation_bound' => $this->seat_reservation_bound
        ];
    }
}
