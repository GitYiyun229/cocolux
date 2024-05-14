<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductOptions;
use App\Models\Voucher;
use Illuminate\Http\Request;
use App\DataTables\VoucherDataTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VoucherDataTable $dataTable)
    {
        return $dataTable->render('admin.voucher.index');
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
    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        $products_add = array();
        if ($voucher->products_add){
            $products_add = ProductOptions::select('id','title','slug','sku','images','price')->whereIn('id',explode(',',$voucher->products_add))->get();
        }
        return view('admin.voucher.update', compact('voucher','products_add'));
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
        DB::beginTransaction();
        try {
            $data['active'] = $request->input('active');
            $data['products_add'] = $request->input('products_add');
            $store = Voucher::findOrFail($id);
            $store->update($data);
            DB::commit();
            Session::flash('success', trans('message.update_store_success'));
            return redirect()->route('admin.voucher.edit', $id);
        } catch (\Exception $exception) {
            \Log::info([
                'message' => $exception->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            Session::flash('danger', trans('message.update_store_error'));
            return back();
        }
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

    /**
     * @param $id
     * @return array
     */
    public function changeActive($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->update(['active' => !$voucher->active]);
        return [
            'status' => true,
            'message' => trans('message.change_active_voucher_success')
        ];
    }
}
