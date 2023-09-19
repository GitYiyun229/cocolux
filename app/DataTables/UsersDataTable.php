<?php

namespace App\DataTables;

use App\Models\User;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
            ->addColumn('type_format', function ($q) {
                return User::TYPE_ROLE[$q->type];
            })
            ->editColumn('created_at', function ($q) {
                return Carbon::parse($q->created_at)->format('H:i:s Y/m/d');
            })
            ->addColumn('birthday_format', function ($q) {
                return Carbon::parse($q->birthday)->format('Y/m/d');
            })
            ->addColumn('action', function ($q) {
                $urlEdit = route('admin.users.edit', $q->id);
                $urlDelete = route('admin.users.destroy', $q->id);
                $lowerModelName = strtolower(class_basename(new User()));
                return view('admin.components.buttons.edit', compact('urlEdit'))->render() . view('admin.components.buttons.delete', compact('urlDelete', 'lowerModelName'))->render();
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
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
                    ->setTableId('users-table')
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
                    )
                    ->parameters($this->getBuilderParameters());
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
            Column::make('name')->title(trans('form.user.name')),
            Column::make('email')->title(trans('form.user.email')),
            Column::make('phone')->title(trans('form.user.phone')),
            Column::make('address')->title(trans('form.user.address')),
            Column::make('birthday_format')->title(trans('form.user.birthday')),
            Column::make('status')->title(trans('form.user.status'))->render([
                'renderLabelActive(data)'
            ]),
            Column::make('gender')->title(trans('form.user.gender'))->render([
                'renderLabelGender(data)'
            ]),
            Column::make('type_format')->title(trans('form.user.type')),
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
        return 'Users_' . date('YmdHis');
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
