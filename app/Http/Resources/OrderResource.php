<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->order_id,
            'customer_name' => $this->customer?->name ?? 'Unknown',
            'total' => $this->formatted_total,
            'status' => $this->formatted_status,
            'status_value' => $this->status,
            'date' => $this->date?->toIso8601String(),
            'address' => $this->address,
            'items_count' => $this->orderItems->count(),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
