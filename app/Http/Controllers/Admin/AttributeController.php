<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\DataTables\AttributeDataTable;
use App\Http\Requests\Attribute\CreateAttribute;
use App\Http\Requests\Attribute\UpdateAttribute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AttributeDataTable $dataTable)
    {
        return $dataTable->render('admin.attribute.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.attribute.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAttribute $req)
    {
        DB::beginTransaction();
        try {
            $data = $req->validated();
            Attribute::create($data);
            DB::commit();
            Session::flash('success', trans('message.create_attribute_success'));
            return redirect()->back();
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::info([
                'message' => $ex->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);

            Session::flash('danger', trans('message.create_attribute_error'));
            return redirect()->back();
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
    public function edit($id)
    {
        $attribute = Attribute::findOrFail($id);
        return view('admin.attribute.update', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttribute $req, $id)
    {
        try {
            $data = $req->validated();
            $article_category = Attribute::findOrFail($id);
            $article_category->update($data);
            DB::commit();
            Session::flash('success', trans('message.update_attribute_success'));
            return redirect()->route('admin.attribute.edit', $id);
        } catch (\Exception $exception) {
            \Log::info([
                'message' => $exception->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            Session::flash('danger', trans('message.update_attribute_error'));
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
        $cat = Attribute::with('attributeValue')->findOrFail($id);
        if (!empty($cat->attributeValue)){
            return [
                'status' => false,
                'message' => trans('message.delete_attribute_error')
            ];
        }else{
            Attribute::delete($id);
            return [
                'status' => true,
                'message' => trans('message.delete_attribute_success')
            ];
        }
    }
}
