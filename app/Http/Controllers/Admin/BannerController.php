<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\DataTables\BannerDataTable;
use App\Repositories\Contracts\BannerInterface;
use App\Http\Requests\Banner\CreateBanner;
use App\Http\Requests\Banner\UpdateBanner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    protected $bannerRepository;

    public function __construct(BannerInterface $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BannerDataTable $dataTable)
    {
        return $dataTable->render('admin.banner.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $routes = Route::getRoutes()->getRoutesByMethod()['GET'];
        $links = [];
        foreach ($routes as $route) {
            $action = $route->getAction();

            // Kiểm tra xem route có thuộc nhóm có namespace 'web' không
            if (isset($action['namespace']) && $action['namespace'] === 'App\Http\Controllers\Web') {
                $uri = $route->uri();


                // Loại bỏ các tham số đường dẫn ({{...}}) trong URI
                $uriWithoutParameters = preg_replace('/\{\w+\}/', '', $uri);

                // Kiểm tra xem URI có chứa các tham số đường dẫn hay không
                if ($uri === $uriWithoutParameters) {
                    $links[] = route($route->getName());
                }
            }
        }

        return view('admin.banner.create', compact('links'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBanner $req)
    {
        DB::beginTransaction();
        try {
            $data = $req->validated();
            $model = $this->bannerRepository->create($data);

            $fileNameWithoutExtension = urldecode(pathinfo($data['image_url'], PATHINFO_FILENAME));
            $fileName = $fileNameWithoutExtension. '.webp';
            $thumbnail = Image::make(asset($data['image_url']))->encode('webp', 75);
            $thumbnailPath = 'storage/banner/' .$model->id.'-'. $fileName;
            Storage::makeDirectory('public/banner/');
            $thumbnail->save($thumbnailPath);

            DB::commit();
            Session::flash('success', trans('message.create_banner_success'));
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banners $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = $this->bannerRepository->getOneById($id);
        $routes = Route::getRoutes()->getRoutesByMethod()['GET'];
        $links = [];
        foreach ($routes as $route) {
            $action = $route->getAction();

            // Kiểm tra xem route có thuộc nhóm có namespace 'web' không
            if (isset($action['namespace']) && $action['namespace'] === 'App\Http\Controllers\Web') {
                $uri = $route->uri();
                // Loại bỏ các tham số đường dẫn ({{...}}) trong URI
                $uriWithoutParameters = preg_replace('/\{\w+\}/', '', $uri);

                // Kiểm tra xem URI có chứa các tham số đường dẫn hay không
                if ($uri === $uriWithoutParameters) {
                    $links[] = route($route->getName());
                }
            }
        }
        return view('admin.banner.update', compact('banner','links'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateBanner $req)
    {
        DB::beginTransaction();
        try {
            $data = $req->validated();
            $banner = $this->bannerRepository->getOneById($id);
            $banner->update($data);

            $fileNameWithoutExtension = urldecode(pathinfo($data['image_url'], PATHINFO_FILENAME));
            $fileName = $fileNameWithoutExtension. '.webp';
            $thumbnail = Image::make(asset($data['image_url']))->encode('webp', 75);
            $thumbnailPath = 'storage/banner/' .$id.'-'. $fileName;
            Storage::makeDirectory('public/banner/');
            $thumbnail->save($thumbnailPath);

            DB::commit();
            Session::flash('success', trans('message.update_banner_success'));
            return redirect()->route('admin.banner.edit', $id);
        } catch (\Exception $exception) {
            \Log::info([
                'message' => $exception->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            Session::flash('danger', trans('message.update_banner_error'));
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->bannerRepository->getOneById($id);

        $img_path = pathinfo($data->image, PATHINFO_DIRNAME);
        // Đường dẫn tới tệp tin
        $array_resize_ = str_replace($img_path.'/','/public/banner/'.$data->id.'-',$data->image);
        $array_resize_ = str_replace(['.jpg', '.png','.bmp','.gif','.jpeg'],'.webp',$array_resize_);
        Storage::delete($array_resize_);

        $this->bannerRepository->delete($id);

        return [
            'status' => true,
            'message' => trans('message.delete_banner_success')
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function changeActive($id)
    {
        $banner = $this->bannerRepository->getOneById($id);
        $banner->update(['active' => !$banner->active]);
        return [
            'status' => true,
            'message' => trans('message.change_active_banner_success')
        ];
    }
}
