<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sliders;
use Illuminate\Http\Request;
use App\DataTables\SliderDataTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Slide\CreateSlide;
use App\Http\Requests\Slide\UpdateSlide;
use App\Repositories\Contracts\SlideInterface;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    protected $slideRepository;
    protected $resizeImage;

    public function __construct(SlideInterface $slideRepository)
    {
        $this->middleware('auth');
        $this->slideRepository = $slideRepository;
        $this->resizeImage = $this->slideRepository->resizeImage();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SliderDataTable $dataTable)
    {
        return $dataTable->render('admin.slider.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSlide $req)
    {
        DB::beginTransaction();
        try {
            $data = $req->validated();
            $image_root = '';
            if (!empty($data['image'])){
                $image_root = $data['image'];
                $data['image'] = urldecode($image_root);
            }
            $model = $this->slideRepository->create($data);
            if (!empty($data['image'])){
                $this->slideRepository->saveFileUpload($image_root,$this->resizeImage,$model->id,'slider');
            }
            DB::commit();
            Session::flash('success', trans('message.create_slide_success'));
            return redirect()->back();
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::info([
                'message' => $ex->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            Session::flash('danger', trans('message.create_slide_error'));
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sliders  $sliders
     * @return \Illuminate\Http\Response
     */
    public function show(Sliders $sliders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sliders  $sliders
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = $this->slideRepository->getOneById($id);
        return view('admin.slider.update', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sliders  $sliders
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateSlide $req)
    {
        $data_root = $this->slideRepository->getOneById($id);
        DB::beginTransaction();
        try {
            $data = $req->validated();
            $slider = $this->slideRepository->getOneById($id);
            if (!empty($data['image']) && $data_root->image != $data['image']){
                $this->slideRepository->removeImageResize($data_root->image,$this->resizeImage, $id,'slider');
                $data['image'] = $this->slideRepository->saveFileUpload($data['image'],$this->resizeImage, $id,'slider');
            }
            $slider->update($data);
            DB::commit();
            Session::flash('success', trans('message.update_slide_success'));
            return redirect()->route('admin.slider.edit', $id);
        } catch (\Exception $exception) {
            \Log::info([
                'message' => $exception->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            Session::flash('danger', trans('message.update_slide_error'));
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sliders  $sliders
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->slideRepository->getOneById($id);

        // Đường dẫn tới tệp tin
        $resize = $this->resizeImage;
        $img_path = pathinfo($data->image, PATHINFO_DIRNAME);
        foreach ($resize as $item){
            $array_resize_ = str_replace($img_path.'/','/public/slider/'.$item[0].'x'.$item[1].'/'.$data->id.'-',$data->image);
            $array_resize_ = str_replace(['.jpg', '.png','.bmp','.gif','.jpeg'],'.webp',$array_resize_);
            Storage::delete($array_resize_);
        }

        $this->slideRepository->delete($id);

        return [
            'status' => true,
            'message' => trans('message.delete_slide_success')
        ];
    }
}
