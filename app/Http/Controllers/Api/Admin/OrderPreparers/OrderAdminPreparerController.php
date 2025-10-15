<?php

namespace App\Http\Controllers\Api\Admin\OrderPreparers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\Auth\RegisterRequest;
use App\Http\Resources\Admin\order_prepare\OrderPrepareResource;
use App\Models\OrderPreparer;

class OrderAdminPreparerController extends Controller
{
    public function index()
    {
        $preparers = OrderPreparer::all();
        return OrderPrepareResource::collection($preparers);
    }

    public function store(RegisterRequest $request)
    {
        $data = $request->validated();
        $preparer = OrderPreparer::create($data);

        return response()->json([
            'message' => 'Created successfully',
            'data'    => new OrderPrepareResource($preparer),
        ], 201);
    }

    public function show(OrderPreparer $preparer)
    {
        return new OrderPrepareResource($preparer);
    }

    public function update(RegisterRequest $request, OrderPreparer $preparer)
    {
        $data = $request->validated();
        $preparer->update($data);

        return response()->json([
            'message' => 'Updated successfully',
            'data'    => new OrderPrepareResource($preparer),
        ], 200);
    }

    public function destroy(OrderPreparer $preparer)
    {
        $preparer->delete();

        return response()->json([
            'message' => 'Deleted successfully',
        ], 200);
    }
}
