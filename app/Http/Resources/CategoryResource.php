<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id'              => $this->id,
            'parent_id'       => $this->parent_id,
            'parent_category' => optional($this->category)->name,
            'name'            => $this->name,
            'slug'            => $this->slug,
            'logo'            => $this->logo ? url('storage/' . $this->logo)                : null,
            'image'           => $this->image ? url('storage/' . $this->image)              : null,
            'banner_image'    => $this->banner_image ? url('storage/' . $this->banner_image) : null,
            'description'     => $this->description,
            'status'          => $this->status,
            'added_by'        => $this->added_by,
            'update_by'       => $this->update_by,
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
        ];
    }
}
