<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\SettingDataTable;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Setting\CreateSetting;
use App\Http\Requests\Setting\UpdateSetting;
use App\Repositories\Contracts\SettingInterface;

class SettingController extends Controller
{
    protected $settingRepository;
    /**
     * SettingController constructor.
     * @param SettingInterface $userRepository
     */
    public function __construct(SettingInterface $settingRepository)
    {
        $this->middleware('auth');
        $this->settingRepository = $settingRepository;
    }
    /**
     * Display a listing of the resource.
     * @param  SettingDataTable  $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(SettingDataTable $dataTable)
    {
        return $dataTable->render('admin.setting.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $template = request()->query('template');
        $types = Setting::SETTING_TYPE;
        return view('admin.setting.create', compact('types','template'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSetting $req)
    {
        DB::beginTransaction();
        try {
            $data = $req->validated();
            $this->settingRepository->create([
                'name' => $data['name'],
                'key' => $data['key'],
                'value' => $data['value'],
                'type' => $data['type'],
                'active' => $data['active'],
                'description' => $data['description'],
            ]);
            DB::commit();
            Session::flash('success', trans('message.create_setting_success'));
            return redirect()->back();
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::info([
                'message' => $ex->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);

            Session::flash('danger', trans('message.create_setting_error'));
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
        $template = request()->query('template');
        $types = Setting::SETTING_TYPE;
        $setting = $this->settingRepository->getOneById($id);
        return view('admin.setting.update', compact('setting','types','template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateSetting $req)
    {
        try {
            $data = $req->validated();
            $setting = $this->settingRepository->getOneById($id);

            $image = null;
            if (\request()->hasFile('value')) {
                $image = $this->settingRepository->saveFileUpload($data['value'],'images');
            }

            $setting->update([
                'name' => $data['name'],
                'key' => $data['key'],
                'value' => $image?$image:$data['value'],
                'type' => $data['type'],
                'active' => $data['active'],
                'description' => $data['description'],
            ]);
            DB::commit();
            Session::flash('success', trans('message.update_setting_success'));
            return redirect()->route('admin.setting.edit', $id);
        } catch (\Exception $exception) {
            \Log::info([
                'message' => $exception->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            Session::flash('danger', trans('message.update_setting_error'));
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
        $this->settingRepository->delete($id);

        return [
            'status' => true,
            'message' => trans('message.delete_setting_success')
        ];
    }
}
