<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => (integer) $data->id,
                    'title' => $data->title,
                    'body' => $data->body,
                    'status' => $data->status,
                    'order' => $data->order,
                    'created_by' => $data->created_by,
                    'processed_by' => $data->processed_by
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
