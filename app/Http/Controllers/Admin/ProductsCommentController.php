<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\DataTables\ProductCommentDataTable;
use App\Models\ProductComments;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductsCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductCommentDataTable $dataTable)
    {
        return $dataTable->render('admin.product-comment.index');
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
        $product_comment = ProductComments::findOrFail($id);
        $product = Product::findOrFail($product_comment->product_id);

        return view('admin.product-comment.update', compact('product_comment','product'));
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
            $comment = ProductComments::findOrFail($id);
            $data['name'] = $request->input('name');
            $data['phone'] = $request->input('phone');
            $data['content'] = $request->input('content');
            $data['rating'] = $request->input('rating');
            $data['active'] = $request->input('active');
            $comment->update($data);
            DB::commit();
            Session::flash('success', trans('message.update_product_comment_success'));
            return redirect()->route('admin.product-comment.edit', $id);
        } catch (\Exception $exception) {
            \Log::info([
                'message' => $exception->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            Session::flash('danger', trans('message.update_product_comment_error'));
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
        ProductComments::destroy($id);
        return [
            'status' => true,
            'message' => trans('message.delete_product_comment_success')
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function changeActive($id)
    {
        $product_comment = ProductComments::findOrFail($id);
        $product_comment->update(['active' => !$product_comment->active]);
        return [
            'status' => true,
            'message' => trans('message.change_active_product_comment_success')
        ];
    }
}
