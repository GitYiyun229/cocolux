<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValues;
use App\Models\ProductOptions;
use App\Models\Stocks;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
    public function create($id_parent)
    {
        $link_submit = route('admin.product-option.store');
        $product_parent = $id_parent;
        $stores = Store::all();
        return view('admin.product.form.input_option', compact('link_submit','product_parent','stores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            if (empty($request->input('slug'))){
                $data['slug'] = $request->input('name')?\Str::slug($request->input('name'), '-'):'';
            }else{
                $data['slug'] = \Str::slug($request->input('slug'), '-');
            }
            $total_stock = $request->input('stock');
            $parent_id = $request->input('parent_id');
            $is_default = $request->input('is_default');
            $data['sku'] = $request->input('sku');
            $data['barcode'] = $request->input('barcode');
            $data['title'] = $request->input('name');
            $data['price'] = $request->input('price');
            $data['normal_price'] = $request->input('normal_price');
            $data['active'] = $request->input('active');
            $data['is_default'] = $is_default;
            $data['parent_id'] = $parent_id;
            if ($is_default){
                ProductOptions::where('parent_id', $parent_id)->update(['is_default' => 0]);
            }
            $product_option = ProductOptions::create($data);

            foreach ($total_stock as $item){
                $id_store = explode(':',$item);
                if ($id_store[1]){
                    $store = Store::findOrFail($id_store[0]);
                    $data['store_id'] = $id_store[0];
                    $data['store_name'] = $store->name;
                    $data['product_id'] = $parent_id;
                    $data['product_option_id'] = $product_option->id;
                    $data['total_quantity'] = $id_store[1];
                    $data['total_order_quantity'] = 0;
                    Stocks::create($data);
                }
            }

            DB::commit();
            return [
                'status' => true,
                'message' => 'Lưu thành công'
            ];
        } catch (\Exception $exception) {
            \Log::info([
                'message' => $exception->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            return [
                'status' => false,
                'message' => 'Lưu không thành công'
            ];
        }
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
        $product_parent = $product_option->parent_id;
        $images = json_decode($product_option->images);
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
                        $values['id_stock'] = $value['id'];
                        $values['total_quantity'] = $value['total_quantity'];
                        $values['total_order_quantity'] = $value['total_order_quantity'];
                    }
                    $item->number = $values;
                }
            }
        }
        $link_submit = route('admin.product-option.update');
        return view('admin.product.form.input_option', compact('product_option','stores','count_stock','images','link_submit','product_parent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        $data_root = ProductOptions::findOrFail($id);
        DB::beginTransaction();
        try {
            if (empty($request->input('slug'))){
                $data['slug'] = $request->input('name')?\Str::slug($request->input('name'), '-'):'';
            }else{
                $data['slug'] = \Str::slug($request->input('slug'), '-');
            }
            $total_stock = $request->input('stock');
            $parent_id = $request->input('parent_id');
            $is_default = $request->input('is_default');
            $data['sku'] = $request->input('sku');
            $data['barcode'] = $request->input('barcode');
            $data['title'] = $request->input('name');
            $data['price'] = $request->input('price');
            $data['normal_price'] = $request->input('normal_price');
            $data['active'] = $request->input('active');
            $data['is_default'] = $is_default;
            $data['parent_id'] = $parent_id;
            if ($is_default){
                ProductOptions::where('parent_id', $parent_id)->where('id','!=',$id)->update(['is_default' => 0]);
            }
            foreach ($total_stock as $item){
                $id_store = explode(':',$item);
                if ($id_store[2]){
                    $stock = Stocks::findOrFail($id_store[2]);
                    if ($stock) {
                        $data['total_quantity'] = $id_store[1];
                        $stock->update($data);
                    }
                }else{
                    if ($id_store[1]){
                        $store = Store::findOrFail($id_store[0]);
                        $data['store_id'] = $id_store[0];
                        $data['store_name'] = $store->name;
                        $data['product_id'] = $parent_id;
                        $data['product_option_id'] = $id;
                        $data['total_quantity'] = $id_store[1];
                        $data['total_order_quantity'] = 0;
                        Stocks::create($data);
                    }
                }
            }

            $data_root->update($data);
            DB::commit();
            return [
                'status' => true,
                'message' => 'Lưu thành công'
            ];
        } catch (\Exception $exception) {
            \Log::info([
                'message' => $exception->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            return [
                'status' => false,
                'message' => 'Lưu không thành công'
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $data = ProductOptions::findOrFail($id);
        if ($data){
            ProductOptions::destroy($id);
            Stocks::where('product_option_id', $id)->delete();
            return [
                'status' => true,
                'message' => trans('message.delete_product_option_success')
            ];
        }else{
            return [
                'status' => false,
                'message' => trans('message.delete_product_option_error')
            ];
        }

    }
}
