<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Scopes\AttributeValueDataTableScope;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValues;
use Illuminate\Http\Request;
use App\DataTables\AttributeValueDataTable;
use App\Http\Requests\Attribute\CreateAttributeValue;
use App\Http\Requests\Attribute\UpdateAttributeValue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AttributeValueDataTable $dataTable)
    {
        $data = request()->all();
        $categories = Attribute::all();
        if ($categories->count() == 0){
            Session::flash('danger', 'Chưa có danh mục nào');
            return redirect()->route('admin.attribute.index');
        }
        return $dataTable->addScope(new AttributeValueDataTableScope())->render('admin.attribute-value.index', compact('data','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Attribute::all();
        return view('admin.attribute-value.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAttributeValue $req)
    {
        DB::beginTransaction();
        try {
            $data = $req->validated();
            $data['slug'] = $req->input('slug')?\Str::slug($req->input('slug'), '-'):\Str::slug($data['name'], '-');
            if (!empty($data['image'])){
                $image_root = $data['image'];
                $data['image'] = urldecode($image_root);
            }
            $model = AttributeValues::create($data);
            DB::commit();
            Session::flash('success', trans('message.create_attribute_value_success'));
            return redirect()->back();
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::info([
                'message' => $ex->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);

            Session::flash('danger', trans('message.create_attribute_value_error'));
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
        $attribute_value = AttributeValues::findOrFail($id);
        $categories = Attribute::all();
        return view('admin.attribute-value.update', compact('attribute_value','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttributeValue $req, $id)
    {
        try {
            $data = $req->validated();
            $attribute_value = AttributeValues::findOrFail($id);
            if (empty($data['slug'])){
                $data['slug'] = $req->input('slug')?\Str::slug($req->input('slug'), '-'):\Str::slug($data['name'], '-');
            }
            $attribute_value->update($data);
            DB::commit();
            Session::flash('success', trans('message.update_attribute_value_success'));
            return redirect()->route('admin.attribute-value.edit', $id);
        } catch (\Exception $exception) {
            \Log::info([
                'message' => $exception->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            Session::flash('danger', trans('message.update_attribute_value_error'));
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
        $attribute_value = AttributeValues::findOrFail($id);
        $attribute_value->delete();

        return [
            'status' => true,
            'message' => trans('message.delete_attribute_value_success')
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function changeActive($id)
    {
        $attribute_value = AttributeValues::findOrFail($id);
        $attribute_value->update(['active' => !$attribute_value->active]);
        return [
            'status' => true,
            'message' => trans('message.change_active_attribute_value_success')
        ];
    }
    /**
     * @param $id
     * @return array
     */
    public function changeIsHome($id)
    {
        $attribute_value = AttributeValues::findOrFail($id);
        $attribute_value->update(['is_home' => !$attribute_value->is_home]);
        return [
            'status' => true,
            'message' => trans('message.change_is_home_attribute_value_success')
        ];
    }
}
