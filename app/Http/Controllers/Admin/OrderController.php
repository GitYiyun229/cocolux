<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductOptions;
use Illuminate\Http\Request;
use App\DataTables\OrderDataTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order-product.index');
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
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $baokim_hook = '';
        if ($order->baokim_message == 'Đã thanh toán thành công qua Bảo Kim'){
            $baokim_hook = json_decode($order->baokim_hook);
        }
        $products = OrderItem::with(['productOption' => function($query){
            $query->select('id','sku','slug','title');
        }])->where('order_id', $id)->get();
        $total_money = 0;
        if (!empty($products)){
            foreach ($products as $item){
                $item_total = $item->product_number*$item->product_price;
                $total_money = $total_money+$item_total;
            }
        }
        return view('admin.order-product.update', compact('order','products','total_money','baokim_hook'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $order = Order::findOrFail($id);
            $data['coco_note'] = $request->input('coco_note');
            $data['status'] = $request->input('status');
            $order->update($data);
            DB::commit();
            Session::flash('success', trans('message.update_order_success'));
            return redirect()->route('admin.order-product.edit', $id);
        } catch (\Exception $exception) {
            \Log::info([
                'message' => $exception->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            Session::flash('danger', trans('message.update_order_error'));
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
