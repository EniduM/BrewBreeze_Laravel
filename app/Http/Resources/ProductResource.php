<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => (string) $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => (float) $this->price,
            'imageUrl' => $this->image_url ?? $this->image ?? 
                'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=400',
            'roastLevel' => $this->roast_level,
            'origin' => $this->origin,
            'category' => $this->category,
            'source' => 'ssp_api',
        ];
    }
}
