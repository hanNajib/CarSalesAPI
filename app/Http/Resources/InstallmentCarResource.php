<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstallmentCarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "car" => $this->cars,
            "brand" => $this->brand->brand,
            "price" => $this->price,
            "description" => $this->description,
            "available_month" => $this->availableMonth->map(fn($month) => [
                'month' => $month->month,
                'description' => $month->description
            ])
        ];
    }
}
