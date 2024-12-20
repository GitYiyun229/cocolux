<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Store;
use Illuminate\Http\Request;
use App\DataTables\StoreDataTable;
use App\Http\Requests\Store\UpdateStore;
use App\Http\Requests\Store\CreateStore;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Repositories\Contracts\StoreInterface;
use App\Models\Districts;
use App\Models\Wards;

class StoreController extends Controller
{
    protected $storeRepository;

    public function __construct(StoreInterface $storeRepository)
    {
        $this->middleware('auth');
        $this->storeRepository = $storeRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StoreDataTable $dataTable)
    {
        return $dataTable->render('admin.store.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $list_city = City::all();
        $list_district = Districts::all();
        $list_wards = Wards::all();
        return view('admin.store.create', compact('list_city', 'list_district', 'list_wards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateStore $req)
    {
        DB::beginTransaction();
        try {
            $data = $req->validated();
            $this->storeRepository->create($data);
            DB::commit();
            Session::flash('success', trans('message.create_store_success'));
            return redirect()->back();
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::info([
                'message' => $ex->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            Session::flash('danger', trans('message.create_store_error'));
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $store = $this->storeRepository->getOneById($id);
        $list_city = City::all();
        // $list_city = City::has('store')->get();
        $list_district = Districts::has('store')->get();
        $list_wards = Wards::has('store')->get();
        return view('admin.store.update', compact('store','list_city', 'list_district', 'list_wards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateStore $req)
    {
        DB::beginTransaction();
        try {
            $data = $req->validated();
            $store = $this->storeRepository->getOneById($id);
            $store->update($data);
            DB::commit();
            Session::flash('success', trans('message.update_store_success'));
            return redirect()->route('admin.store.edit', $id);
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
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->storeRepository->delete($id);

        return [
            'status' => true,
            'message' => trans('message.delete_store_success')
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function changeActive($id)
    {
        $store = $this->storeRepository->getOneById($id);
        $store->update(['active' => !$store->active]);
        return [
            'status' => true,
            'message' => trans('message.change_active_store_success')
        ];
    }
    /**
     * @param $id
     * @return array
     */
    public function changeIsHome($id)
    {
        $store = Store::findOrFail($id);
        $store->update(['is_home' => !$store->is_home]);
        return [
            'status' => true,
            'message' => trans('message.change_is_home_store_success')
        ];
    }
}
