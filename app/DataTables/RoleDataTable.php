<?php

namespace App\DataTables;

use App\Models\Role;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends DataTable
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
            ->editColumn('created_at', function ($q) {
                return Carbon::parse($q->created_at)->format('H:i:s Y/m/d');
            })
            ->addColumn('permissions', function ($q) {
                return optional($q->permissions())->pluck('display_name')->toArray();
            })
            ->addColumn('action', function ($q) {
                $urlEdit = route('admin.roles.edit', $q->id);
                $urlDelete = route('admin.roles.destroy', $q->id);
                $lowerModelName = strtolower(class_basename(new Role()));
                return view('admin.components.buttons.edit', compact('urlEdit'))->render() . view('admin.components.buttons.delete', compact('urlDelete', 'lowerModelName'))->render();
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Role $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('role-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
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
            Column::make('display_name')->title(trans('form.user.name')),
            Column::computed('permissions')->title(trans('form.permissions'))->render([
                'renderDataAsBadge(data)'
            ]),
            Column::make('created_at')->title(trans('form.created_at')),
            Column::computed('action')->title(trans('form.action'))
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
        return 'Role_' . date('YmdHis');
    }

    /**
     * Get default builder parameters.
     *
     * @return array
     */
    protected function getBuilderParameters()
    {
        return [
            'dom' => "<'row btn-table '<'col-sm-6'><'col-sm-6 dataTables_filter'B>>".
                "<'row'<'col-sm-6'l><'col-sm-6'f>>" .
                "<'row'<'col-sm-12'tr>>" .
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            'language' => [
                'url' => asset('vendor/datatables/languages/Vietnamese.json')
            ],
        ];
    }
}
