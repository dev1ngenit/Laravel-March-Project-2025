<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'slug'                => $this->slug,
            'category_id'         => $this->category_id,
            'category_name'       => optional($this->category)->name,
            'brand_id'            => $this->brand_id,
            'brand_name'          => optional($this->brand)->name,
            'thumbnail_image'     => $this->thumbnail_image ? url('storage/' . $this->thumbnail_image) : null,
            'sku'                 => $this->sku,
            'mf_code'             => $this->mf_code,
            'short_description'   => $this->short_description,
            'long_description'    => $this->long_description,
            'specification'       => $this->specification,
            'qty'                 => $this->qty,
            'currency'            => $this->currency,
            'price'               => $this->price,
            'partner_price'       => $this->partner_price,
            'discount_price'      => $this->discount_price,
            'supplier'            => $this->supplier,
            'warehouse_location'  => $this->warehouse_location,
            'weight'              => $this->weight,
            'tags'                => $this->tags,
            'is_featured'         => $this->is_featured,
            'is_selling'          => $this->is_selling,
            'is_new'              => $this->is_new,
            'hot_deal'            => $this->hot_deal,
            'status'              => $this->status,
            'meta_title'          => $this->meta_title,
            'meta_keyword'        => $this->meta_keyword,
            'meta_content'        => $this->meta_content,
            'meta_description'    => $this->meta_description,
            'added_by'            => $this->added_by,
            'added_by_name'       => optional($this->addedBy)->name,
            'update_by'           => $this->update_by,
            'update_by_name'      => optional($this->updateBy)->name,
            'created_at'          => $this->created_at,
            'updated_at'          => $this->updated_at,
        ];
    }
}
