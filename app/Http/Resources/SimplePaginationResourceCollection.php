<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SimplePaginationResourceCollection extends ResourceCollection
{
    protected array $pagination;

    public function __construct($resource) {
        $this->pagination = [
            'total' => $resource->total(),
            'last_page' => $resource->lastPage()
        ];
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'meta' => $this->pagination
        ];
    }
}
