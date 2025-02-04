<?php

namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Models\Product;

class ProductRepository implements ProductInterface
{
    public function getAll()
    {
        return Product::all();
    }

    public function create(array $data)
    {

        if (isset($data['image']) && $data['image']->isValid()) {
            $uploadFolderName = 'image/products';
            $file = $data['image'];
            $extension = $file->extension();
            $fileName = time() . '_' . rand(1000, 9999) . '.' . $extension;
            $file->move(public_path("$uploadFolderName"), $fileName);
            $data['image'] = $fileName;
        }


        return  Product::create($data);
    }

    public function find($id)
    {
        return Product::find($id);
    }

    public function update($id, array $data)
    {
        $product = Product::findOrFail($id);

        if (isset($data['image']) && $data['image']->isValid()) {
            $uploadFolderName = 'img/products';
            $file = $data['image'];
            $fileName = time() . '_' . rand(1000, 9999) . '.' . $file->extension();
            $file->move(public_path($uploadFolderName), $fileName);

            // Delete old image if exists
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $data['image'] = "$uploadFolderName/$fileName";
        }

        return $product->update($data);
    }
    public function delete($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }
        $product->delete();
        return true;
    }
}
