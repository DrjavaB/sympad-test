<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageRequest;
use App\Http\Resources\SimplePaginationResourceCollection;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\NoReturn;

class UserController extends Controller
{

    public function allUsers(PageRequest $request)
    {
        $search = sprintf('%%%s%%', $request->search);

        $users = User::query()
            /* Broad search */
            ->when($request->filled('search'), fn(Builder $query) => $query
                ->where('name', 'like', $search)
                ->orWhere('username', 'like', $search)
                ->orWhere('mobile', 'like', $search)
                ->orWhere('national_id', 'like', $search)
            )
            /* Exact search */
            ->when($request->filled('name'), fn(Builder $query) => $query->where('name', 'like', "%$request->name%"))
            ->when($request->filled('username'), fn(Builder $query) => $query->where('username', 'like', "%$request->username%"))
            ->when($request->filled('mobile'), fn(Builder $query) => $query->where('mobile', 'like', "%$request->mobile%"))
            ->when($request->filled('national_id'), fn(Builder $query) => $query->where('national_id', 'like', "%$request->national_id%"))
            ->when(
                $request->filled('order_by'),
                fn(Builder $query) => $query->orderBy($request->order_by, $request->direction),
                fn(Builder $query) => $query->orderBy('id', 'desc')
            )
            ->paginate();
        // mutate pagination response
        return response()->json(new SimplePaginationResourceCollection($users));
    }

    #[NoReturn] public function me(): JsonResponse
    {
        return successResponse(auth()->user());
    }
}
