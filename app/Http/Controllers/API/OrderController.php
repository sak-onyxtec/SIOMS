<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}
    public function addOrder(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "items" => "required|array|min:1",
            "items.*.product_id" => "required|exists:products,id",
            "items.*.quantity" => "required|integer|gt:0",
        ]);

        if ($validation->fails()) {
            return response([
                "status" => 422,
                "message" => $validation->errors()->first(),
                "errors" => $validation->errors()
            ], 422);
        }

        $order = $this->orderService->addOrder($request);

        $response = [
            "status" => 200,
            "message" => "Order Added Successfully",
            "order" => $order
        ];

        return response($response, $response['status']);
    }

    public function updateOrder(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            "items" => "required|array|min:1",
            "items.*.product_id" => "required|exists:products,id",
            "items.*.quantity" => "required|integer|gt:0",
        ]);

        if ($validation->fails()) {
            return response([
                "status" => 422,
                "message" => $validation->errors()->first(),
                "errors" => $validation->errors()
            ], 422);
        }

        $order = $this->orderService->updateOrder($request, $id);
        if (isset($order)) {
            $response = [
                "status" => 200,
                "message" => "Order Updated Successfully",
                "order" => $order
            ];
        } else {
            $response = [
                "status" => 422,
                "message" => "Order Not Found"
            ];
        }

        return response($response, $response['status']);
    }

    public function getOrders(Request $request)
    {

        $response = $this->orderService->getOrders($request);
        return response($response, $response['status']);
    }

    public function getOrder(Request $request, $id)
    {
        $order = Order::find($id);
        if (isset($order)) {
            $response = [
                "status" => 200,
                "message" => "Order Fetched Successfully",
                "order" => $order
            ];
        } else {
            $response = [
                "status" => 422,
                "message" => "Order Not Found"
            ];
        }

        return response($response, $response['status']);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            "status" => [
                "required",
                Rule::in(['pending', 'processing', 'completed', 'cancelled']),
            ],
        ]);

        if ($validation->fails()) {
            return response([
                "status" => 422,
                "message" => $validation->errors()->first(),
                "errors" => $validation->errors()
            ], 422);
        }

        $order = $this->orderService->changeOrderStatus($request, $id);
        if (isset($order)) {
            $response = [
                "status" => 200,
                "message" => "Order Status Updated Successfully",
                "order" => $order
            ];
        } else {
            $response = [
                "status" => 422,
                "message" => "Order Not Found"
            ];
        }

        return response($response, $response['status']);
    }

    public function deleteOrder(Request $request, $id)
    {
        $order = $this->orderService->deleteOrder($request, $id);
        if (isset($order)) {
            $response = [
                "status" => 200,
                "message" => "Order Deleted Successfully",
            ];
        } else {
            $response = [
                "status" => 422,
                "message" => "Order Not Found"
            ];
        }

        return response($response, $response['status']);
    }
}
