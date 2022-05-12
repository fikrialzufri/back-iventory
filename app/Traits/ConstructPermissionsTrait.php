<?php

namespace App\Traits;

trait ConstructPermissionsTrait
{
    public function __construct()
    {
        $this->middleware('permission:view-' . $this->routeName(), ['only' => ['index', 'show']]);
        $this->middleware('permission:create-' . $this->routeName(), ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-' . $this->routeName(), ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-' . $this->routeName(), ['only' => ['delete']]);
    }
}
