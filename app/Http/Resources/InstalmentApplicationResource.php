<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstalmentApplicationResource extends JsonResource
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
            "applications" => $this->installmentApplySocieties()->with("availableMonth")->get()->map(function($application) {
                return [
                    "month" => $application->availableMonth->month,
                    "nominal" => $application->availableMonth->nominal ?? null,
                    "apply_status" => $application->installment_apply_status,
                    "notes" => $application->notes
                ];
            })
        ];
    }
}
