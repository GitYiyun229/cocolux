<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Repositories\Contracts\ArticleCategoryInterface;
use App\Repositories\Contracts\ArticleInterface;
use App\Repositories\Contracts\MenuCategoryInterface;
use App\Repositories\Contracts\MenuInterface;
use App\Repositories\Contracts\PageInterface;
use App\Repositories\Contracts\ProductCategoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Menu\CreateMenu;

class MenuController extends Controller
{
    protected $articleCategoryRepository, $articleRepository, $menuCategoryRepository, $menuRepository, $pageRepository, $productRepository;

    public function __construct(
        ArticleCategoryInterface $articleCategoryRepository,
        ArticleInterface $articleRepository,
        MenuCategoryInterface $menuCategoryRepository,
        MenuInterface $menuRepository,
        PageInterface $pageRepository,
        ProductCategoryInterface $productRepository
    )
    {
        $this->articleCategoryRepository = $articleCategoryRepository;
        $this->articleRepository = $articleRepository;
        $this->menuCategoryRepository = $menuCategoryRepository;
        $this->menuRepository = $menuRepository;
        $this->pageRepository = $pageRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category_id = request()->query('category_id');
        $menu_categories = $this->menuCategoryRepository->getList(null,['*'],null);
        if ($menu_categories->count() === 0){
            Session::flash('danger', 'Chưa có nhóm menu nào');
            return redirect()->route('admin.menu-category.index');
        }
        $page_thongtin = Page::where(['page_cat_id' => 3,'active' => 1])->select('id','slug','title')->get();
        if (empty($category_id)){
            $category_id = $menu_categories->first()->id;
        }
        $menu = $this->menuRepository->getMenusByCategoryId($category_id)->toTree();
        return view('admin.menu.index', compact('menu_categories','menu','category_id','page_thongtin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMenu $req)
    {
        DB::beginTransaction();
        try {
            $data = $req->validated();
            $menu = $this->menuRepository->create($data);
            DB::commit();
            $id_menu = [
                'id' => $menu->id
            ];
            return $id_menu;
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::info([
                'message' => $ex->getMessage(),
                'line' => __LINE__,
                'method' => __METHOD__
            ]);
            return false;
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
        $this->menuRepository->delete($id);

        return [
            'status' => true,
            'message' => trans('message.delete_menu_success')
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param updateTree $request
     * @return \Illuminate\Http\Response
     */
    public function updateTree(Request $request)
    {
        $local = request()->query('local','vi');
        $data = $request->data;
        $this->menuRepository->updateTreeRebuild('id', $data);
//        $translations = $this->menuRepository->with(['translations']);
//        $data['lang'] = $local;
//        $translations->updateTreeRebuild('id', $data);
        return response()->json($data);
    }
}
