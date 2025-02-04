<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Interfaces\ProductInterface;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponseTrait;

    protected $productRepository;

    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function index()
    {
        $result = $this->productRepository->getAll();
        return $this->successResponse($result, 'Successfully retrieved products', 200);
    }

    public function store(ProductRequest $request)
    {
        $result =  $this->productRepository->create($request->validated());
        return $this->successResponse($result, 'Successfully added new product', 201);
    }

    public function show(string $id)
    {
        $product =  $this->productRepository->find($id);
        if (!$product) {
            return $this->successResponse($product, 'Successfully retrieved product', 200);
        } else {
            return $this->errorResponse($product, 'Product not found', 404);
        }
    }

    public function update(ProductRequest $request, $id)
    {
        $updatedProduct = $this->productRepository->update($id, $request->validated());

        return $this->successResponse(
            $updatedProduct,
            'Product updated successfully',
            200
        );
    }

    public function destroy($id)
    {
        $this->productRepository->delete($id);

        return $this->successResponse([], 'Product deleted successfully', 200);
    }
}
