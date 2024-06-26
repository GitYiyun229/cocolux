<?php

namespace App\DataTables;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Optional;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('active', function ($q) {
                $url = route('admin.product.changeActive', $q->id);
                $status = $q->active == Product::STATUS_ACTIVE ? 'checked' : null;
                return view('admin.components.buttons.change_status', [
                    'url' => $url,
                    'lowerModelName' => 'product',
                    'status' => $status,
                ])->render();
            })
            ->editColumn('is_home', function ($q) {
                $url = route('admin.product.changeIsHome', $q->id);
                $status = $q->is_home == Product::IS_HOME ? 'checked' : null;
                return view('admin.components.buttons.change_status', [
                    'url' => $url,
                    'lowerModelName' => 'product',
                    'status' => $status,
                ])->render();
            })
            ->editColumn('is_new', function ($q) {
                $url = route('admin.product.changeIsNew', $q->id);
                $status = $q->is_new == Product::IS_NEW ? 'checked' : null;
                return view('admin.components.buttons.change_status', [
                    'url' => $url,
                    'lowerModelName' => 'product',
                    'status' => $status,
                ])->render();
            })
            ->editColumn('is_hot', function ($q) {
                $url = route('admin.product.changeIsHot', $q->id);
                $status = $q->is_hot == Product::IS_HOT ? 'checked' : null;
                return view('admin.components.buttons.change_status', [
                    'url' => $url,
                    'lowerModelName' => 'product',
                    'status' => $status,
                ])->render();
            })
            ->addColumn('productOption', function ($q) {
                $skus = $q->productOption->pluck('sku')->toArray();
                return implode(', ', $skus);
            })
            ->editColumn('created_at', function ($q) {
                return Carbon::parse($q->created_at)->format('H:i:s Y/m/d');
            })
            ->editColumn('updated_at', function ($q) {
                return Carbon::parse($q->updated_at)->format('H:i:s Y/m/d');
            })
            ->addColumn('action', function ($q) {
                $urlEdit = route('admin.product.edit', $q->id);
                $urlDelete = route('admin.product.destroy', $q->id);
                $lowerModelName = strtolower(class_basename(new Product()));
                return view('admin.components.buttons.edit', compact('urlEdit'))->render() . view('admin.components.buttons.delete', compact('urlDelete', 'lowerModelName'))->render();
            })->rawColumns(['active','action','is_home','is_hot','is_new']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model)
    {
        return $model->newQuery()->with([
            'category',
            'productOption:id,parent_id,sku,images,slug'
        ]);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('product-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(0)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('title')->title('Tên sản phẩm'),
            Column::make('image')->title(trans('form.product.image'))->render([
                'renderImage(data)'
            ])->searchable(false),
            Column::make('productOption','productOption.sku')->title('Mã'),
            Column::make('active')->title('Kích hoạt')->searchable(false),
            Column::make('is_home')->title('Hiển thị trang chủ')->searchable(false),
            Column::make('is_hot')->title('SP Hot')->searchable(false),
            Column::make('is_new')->title('SP Mới')->searchable(false),
            Column::make('created_at')->title('Thời gian tạo'),
            Column::make('updated_at')->title('Thời gian sửa'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Product_' . date('YmdHis');
    }
}
