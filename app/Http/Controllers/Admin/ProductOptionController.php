<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductOptions;
use App\Models\Store;
use Illuminate\Http\Request;

class ProductOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id =  $request->input('id');
        $product_option = ProductOptions::where(['id'=>$id])->with('stocksAll')->first();
        $stocks = !empty($product_option->stocksAll)?$product_option->stocksAll:null;
        $count_stock = 0;
        foreach ($stocks as $item){
            $count_stock = $count_stock + $item->total_quantity;
        }
        $stores = Store::all();
        foreach ($stores as $item){
            if ($stocks){
                $result = array_filter($stocks->toArray(), function ($value) use ($item) {
                    return $value['store_id'] == $item->id;
                });
                if (!empty($result)) {
                    $values = [];
                    foreach ($result as $value) {
                        $values['id'] = $value['id'];
                        $values['content'] = $value['total_quantity'];
                    }
                    $item->content = $values;
                }
            }
        }
        return view('admin.product.form.input_option', compact('product_option','stores','count_stock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
