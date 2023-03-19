<?php

namespace App\Http\Resources\Idocs;

use Illuminate\Http\Resources\Json\JsonResource;

class ExternalDocsmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "group" => $this["DocumentGroup"],
            "content_name" => $this["DocumentContentName"],
            "extension" => $this["DocumentExtension"],
            "doc_id" => $this["DocumentId"],
            "name" => $this["DocumentName"],
            "number" => $this["DocumentNumber"],
            "status" => $this["DocumentStatus"],
        ];
    }
}
