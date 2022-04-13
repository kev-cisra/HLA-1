<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product as ResourcesProduct;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{


    public function index()

    {

        $products = Product::all();



        return $this->sendResponse(ResourcesProduct::collection($products), 'Products retrieved successfully.');

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $input = $request->all();


        $product = Product::create($input);



        return $this->sendResponse(new ResourcesProduct($product), 'Product created successfully.');

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        $product = Product::find($id);



        if (is_null($product)) {

            return $this->sendError('Product not found.');

        }



        return $this->sendResponse(new ResourcesProduct($product), 'Product retrieved successfully.');

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, Product $product)

    {

        $input = $request->all();


        $product->name = $input['name'];

        $product->detail = $input['detail'];

        $product->save();



        return $this->sendResponse(new ResourcesProduct($product), 'Product updated successfully.');

    }



    public function destroy(Product $product)

    {

        $product->delete();



        return $this->sendResponse([], 'Product deleted successfully.');

    }
}
