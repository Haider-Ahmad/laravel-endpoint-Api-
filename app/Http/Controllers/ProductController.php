<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //all
    public function index()
    {
        try {
            return Product::all();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle the case where the product is not found
            return response()->json(['error' => 'Product not found'], 404);
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json(['error' => 'An unexpected error occurred: ' . $e->getMessage()], 500);
        }
    }

    //create
    public function create(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:50',
                'price' => 'required|numeric',
                'description' => 'nullable|string',
            ]);
            $product = Product::create($request->all());
            return new JsonResponse([
                'status' => '201',
                'products' => $product
            ], 201);
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json(['error' => 'An unexpected error occurred: ' . $e->getMessage()], 500);
        }
    }

    // single product
    public function singleProduct($id)
    {
        try {
            return Product::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle the case where the product is not found
            return response()->json(['error' => 'Product not found'], 404);
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json(['error' => 'An unexpected error occurred: ' . $e->getMessage()], 500);
        }
    }


    //update
    public function update(Request $request, string $id)
    {
        try {

            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:50',
                'price' => 'sometimes|required|numeric',
                'description' => 'sometimes|nullable|string',

            ]);

            $product = Product::findOrFail($id);
            $product->update($validatedData);

            return response()->json([
                'message' => 'updated successfuly',
                'products:' => $product
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle the case where the product is not found
            return response()->json(['error' => 'Product not found'], 404);
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json(['error' => 'An unexpected error occurred: ' . $e->getMessage()], 500);
        }
    }


    //delete
    public function delete($id)
    {
        try {

            $product = Product::findOrFail($id);
            $product->delete();
            return new JsonResponse(['success' => 'has been removed successfuly'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            // Handle the case where the product is not found
            return new JsonResponse(['error' => 'Product not found'], 404);
        } catch (\Exception $e) {
            // Handle any other exceptions
            return new JsonResponse(['error' => 'An unexpected error occurred: ' . $e->getMessage()], 500);
        }
    }
}
