<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use App\Repositories\Contracts\MediaImageInterface;
use App\Repositories\Contracts\MediaVideoInterface;

class MediaController extends Controller
{
    protected $mediaImageRepository, $mediaVideoRepository;

    public function __construct(MediaImageInterface $mediaImageRepository, MediaVideoInterface $mediaVideoRepository)
    {
        $this->mediaImageRepository = $mediaImageRepository;
        $this->mediaVideoRepository = $mediaVideoRepository;
    }

    public function album(){
        $images = $this->mediaImageRepository->paginate(9,['id','title','image','created_at'],['active'=>1,'type'=>0],['mediaImages']);
//        $images = Media::with('mediaImages')->select('id','title','image')->get();
        if (!$images) {
            abort(404);
        }
        return view('web.media.album', compact('images'));
    }

    public function video(){
        $videos = $this->mediaVideoRepository->paginate(9,['id','title','image','link_video','created_at'],['active'=>1,'type'=>1]);
//        $videos = Media::select('id','title','image','link_video')->get();
        if (!$videos) {
            abort(404);
        }
        return view('web.media.video', compact('videos'));
    }
}
