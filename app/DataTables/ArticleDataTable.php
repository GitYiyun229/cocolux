<?php

namespace App\DataTables;

use App\Models\Article;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ArticleDataTable extends DataTable
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
                $url = route('admin.article.changeActive', $q->id);
                $status = $q->active == Article::STATUS_ACTIVE ? 'checked' : null;
                return view('admin.components.buttons.change_status', [
                    'url' => $url,
                    'lowerModelName' => 'article',
                    'status' => $status,
                ])->render();
            })
            ->editColumn('is_home', function ($q) {
                $url = route('admin.article.changeIsHome', $q->id);
                $status = $q->is_home == Article::IS_HOME ? 'checked' : null;
                return view('admin.components.buttons.change_status', [
                    'url' => $url,
                    'lowerModelName' => 'article',
                    'status' => $status,
                ])->render();
            })
            ->editColumn('created_at', function ($q) {
                return Carbon::parse($q->created_at)->format('H:i:s Y/m/d');
            })
            ->editColumn('updated_at', function ($q) {
                return Carbon::parse($q->updated_at)->format('H:i:s Y/m/d');
            })
            ->editColumn('category_id', function ($q) {
                return optional($q->category)->title;
            })
            ->addColumn('action', function ($q) {
                $urlEdit = route('admin.article.edit', $q->id);
                $urlDelete = route('admin.article.destroy', $q->id);
                $lowerModelName = strtolower(class_basename(new Article()));
                return view('admin.components.buttons.edit', compact('urlEdit'))->render() . view('admin.components.buttons.delete', compact('urlDelete', 'lowerModelName'))->render();
             })->rawColumns(['active','action','is_home']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Article $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Article $model)
    {
        return $model->newQuery()->with('category');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('article-table')
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
            Column::make('title'),
            Column::make('image_change_url')->title(trans('form.article.image'))->render([
                'renderImage(data)'
            ])->searchable(false),
            Column::make('category_id')->title(trans('form.article_category.'))->searchable(false),
            Column::make('active')->title(trans('form.article.active'))->searchable(false),
            Column::make('is_home')->title(trans('form.home_page'))->searchable(false),
            Column::make('created_at')->title(trans('form.created_at')),
            Column::make('updated_at')->title(trans('form.updated_at')),
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
        return 'Article_' . date('YmdHis');
    }
}
