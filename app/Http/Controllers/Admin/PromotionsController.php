<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PromotionsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Promotions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductPromotionImport;

class PromotionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PromotionsDataTable $dataTable)
    {
        return $dataTable->render('admin.promotion.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.promotion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $type = $request->input('type');
        $file = $request->file('file');

        DB::beginTransaction();
        try {
            $file = $request->file('file');
            $type = $request->input('type');
            $data = array();
            $data['name'] = $request->input('name');
            $data['code'] = $request->input('code');
            $data['type'] = $type;
            $data['applied_start_time'] = Carbon::parse($request->input('applied_start_time'));
            $data['applied_stop_time'] = Carbon::parse($request->input('applied_stop_time'));
            $promotion = Promotions::create($data);
            Excel::import(new ProductPromotionImport($promotion->id, $type, $data['name']), $file);
            DB::commit();
            Session::flash('success', trans('message.create_promotion_success'));
            return redirect()->back();
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::info([
                'message' => $ex->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            Session::flash('danger', trans('message.create_banner_error'));
            return redirect()->back();
        }

        $id_promotion = $request->input('file');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Promotions  $promotions
     * @return \Illuminate\Http\Response
     */
    public function show(Promotions $promotions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promotions  $promotions
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $promotion = Promotions::findOrFail($id);
        return view('admin.promotion.update', compact('promotion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promotions  $promotions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $type = $request->input('type');
        $file = $request->file('file');
        $id_promotion = $id;
        $name_promotion = $request->input('name');

        Excel::import(new ProductPromotionImport($id_promotion, $type, $name_promotion), $file);
        return redirect()->back()->with('success', 'Dữ liệu đã được import thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promotions  $promotions
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Promotions::destroy($id);
        return [
            'status' => true,
            'message' => trans('message.delete_promotion_success')
        ];
    }
}
