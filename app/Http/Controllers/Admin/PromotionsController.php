<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PromotionsDataTable;
use App\Http\Controllers\Controller;
use App\Models\PromotionItem;
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
        DB::beginTransaction();
        try {
            $file = $request->file('file');
            $type = $request->input('type');
            $sort_product = $request->input('sort_product');
            $data = array();
            $data['name'] = $request->input('name');
            $data['link'] = $request->input('link');
            $data['thumbnail_url'] = $request->input('thumbnail_url');
            $data['image_deal'] = $request->input('image_deal');
            $data['type'] = $type;
            $data['sort_product'] = $sort_product;
            $data['applied_start_time'] = Carbon::parse($request->input('applied_start_time'));
            $data['applied_stop_time'] = Carbon::parse($request->input('applied_stop_time'));
            $promotion = Promotions::create($data);

            if ($data['thumbnail_url']) {
                try {
                    $fileNameWithoutExtension = urldecode(pathinfo($data['thumbnail_url'], PATHINFO_FILENAME));
                    $fileName = $fileNameWithoutExtension . '.webp';
                    $thumbnail = Image::make(asset($data['thumbnail_url']))->encode('webp', 75);
                    $thumbnailPath = 'storage/promotion/' . $promotion->id . '-' . $fileName;
                    Storage::makeDirectory('public/promotion/');
                    $thumbnail->save($thumbnailPath);
                } catch (\Exception $e) {
                    \Log::error('Error processing thumbnail URL', [
                        'url' => $data['thumbnail_url'],
                        'error' => $e->getMessage(),
                    ]);
                    throw $e;
                }
            }

            if ($data['image_deal']) {
                try {
                    $fileNameWithoutExtensionsale = urldecode(pathinfo($data['image_deal'], PATHINFO_FILENAME));
                    $fileNameSale = $fileNameWithoutExtensionsale . '.webp';
                    $thumbnailSale = Image::make(asset($data['image_deal']))->encode('webp', 75);
                    $thumbnailPathSale = 'storage/promotion/khung_sale/' . $promotion->id . '-' . $fileNameSale;
                    Storage::makeDirectory('public/promotion/khung_sale/');
                    $thumbnailSale->save($thumbnailPathSale);
                } catch (\Exception $e) {
                    \Log::error('Error processing image deal URL', [
                        'url' => $data['image_deal'],
                        'error' => $e->getMessage(),
                    ]);
                    throw $e;
                }
            }
            if ($file) {
                PromotionItem::where('promotion_id', $promotion->id)->delete();
                Excel::import(new ProductPromotionImport($promotion, $type, $data['name']), $file);
            }
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
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $file = $request->file('file');
            $type = $request->input('type');
            $sort_product = $request->input('sort_product');
            $data = array();
            $data['name'] = $request->input('name');
            $data['link'] = $request->input('link');
            $data['thumbnail_url'] = $request->input('thumbnail_url');
            $data['image_deal'] = $request->input('image_deal');
            $data['type'] = $type;
            $data['sort_product'] = $sort_product;
            $data['applied_start_time'] = Carbon::parse($request->input('applied_start_time'));
            $data['applied_stop_time'] = Carbon::parse($request->input('applied_stop_time'));

            $promotion = Promotions::findOrFail($id);
            $promotion->update($data);

            if ($data['thumbnail_url']) {
                $fileNameWithoutExtension = urldecode(pathinfo($data['thumbnail_url'], PATHINFO_FILENAME));
                $fileName = $fileNameWithoutExtension . '.webp';
                $thumbnail = Image::make(asset($data['thumbnail_url']))->encode('webp', 75);
                $thumbnailPath = 'storage/promotion/' . $id . '-' . $fileName;
                Storage::makeDirectory('public/promotion/');
                $thumbnail->save($thumbnailPath);
            }

            if ($data['image_deal']) {
                try {
                    $fileNameWithoutExtensionSale = urldecode(pathinfo($data['image_deal'], PATHINFO_FILENAME));
                    $fileNameSale = $fileNameWithoutExtensionSale . '.webp';
                    $thumbnailSale = Image::make(asset($data['image_deal']))->encode('webp', 75);
                    $thumbnailPathSale = 'storage/promotion/khung_sale/' . $id . '-' . $fileNameSale;
                    Storage::makeDirectory('public/promotion/khung_sale/');
                    Storage::put($thumbnailPathSale, (string) $thumbnailSale);
                } catch (\Exception $exception) {
                    \Log::error([
                        'message' => $exception->getMessage(),
                        'line' => __LINE__,
                        'method' => __METHOD__
                    ]);
                }
            }
            if ($file) {
                PromotionItem::where('promotion_id', $id)->delete();
                Excel::import(new ProductPromotionImport($promotion, $type, $data['name']), $file);
            } else {
                $data2['applied_start_time'] = $data['applied_start_time'];
                $data2['applied_stop_time'] = $data['applied_stop_time'];
                $data2['image_deal'] = $data['image_deal'];
                $data2['type'] = $type;
                PromotionItem::where('promotion_id', $id)->update($data2);
            }
            DB::commit();
            Session::flash('success', trans('message.update_promotion_success'));
            return redirect()->back();
        } catch (\Exception $exception) {
            \Log::info([
                'message' => $exception->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            Session::flash('danger', trans('message.update_promotion_error'));
            return back();
        }
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
        PromotionItem::where('promotion_id', $id)->delete();
        return [
            'status' => true,
            'message' => trans('message.delete_promotion_success')
        ];
    }
}
