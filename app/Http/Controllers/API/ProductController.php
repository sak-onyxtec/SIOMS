<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService) {}
    public function addProduct(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required",
            "sku" => [
                "required",
                Rule::unique("products", "sku")->whereNull('deleted_at')
            ],
            "category" => "required",
            "price" => "required|numeric|gt:0",
            "quantity" => "required|integer|gt:0",
            "product_image" => "image"
        ]);

        if ($validation->fails()) {
            return response([
                "status" => 422,
                "message" => $validation->errors()->first(),
                "errors" => $validation->errors()
            ], 422);
        }

        $product = $this->productService->addProduct($request);

        $response = [
            "status" => 200,
            "message" => "Product Added Successfully",
            "product" => $product
        ];

        return response($response, $response['status']);
    }

    public function updateProduct(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required",
            "sku" => [
                "required",
                Rule::unique("products", "sku")->ignore($id)->whereNull('deleted_at')
            ],
            "category" => "required",
            "price" => "required|numeric|gt:0",
            "quantity" => "required|integer|gt:0",
            "product_image" => "image"
        ]);

        if ($validation->fails()) {
            return response([
                "status" => 422,
                "message" => $validation->errors()->first(),
                "errors" => $validation->errors()
            ], 422);
        }

        $product = $this->productService->updateProduct($request,$id); 
        if (isset($product)) {
            $response = [
                "status" => 200,
                "message" => "Product Updated Successfully",
                "product" => $product
            ];
        } else {
            $response = [
                "status" => 422,
                "message" => "Product Not Found"
            ];
        }

        return response($response, $response['status']);
    }

    public function getProducts(Request $request)
    {
        
        $response = $this->productService->getProducts($request);
        return response($response, $response['status']);
    }

    public function getProduct(Request $request, $id)
    {
        $product = Product::find($id);
        if (isset($product)) {
            $response = [
                "status" => 200,
                "message" => "Product Fetched Successfully",
                "product" => $product
            ];
        } else {
            $response = [
                "status" => 422,
                "message" => "Product Not Found"
            ];
        }

        return response($response, $response['status']);
    }

    public function deleteProduct(Request $request, $id)
    {
        $product = $this->productService->deleteProduct($request,$id);
        if (isset($product)) {
            $response = [
                "status" => 200,
                "message" => "Product Deleted Successfully",
            ];
        } else {
            $response = [
                "status" => 422,
                "message" => "Product Not Found"
            ];
        }

        return response($response, $response['status']);
    }
}
