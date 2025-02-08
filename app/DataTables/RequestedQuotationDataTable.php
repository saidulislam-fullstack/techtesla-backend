<?php

namespace App\DataTables;

use App\Models\RequestedQuotation;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RequestedQuotationDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $btn = '';
                $btn .= '<div class="btn-group" role="group">';
                if ($query->priceCollection->count() > 0) {
                    $btn .= '<a href="' . route('price-collection.selection', $query->id) . '" class="btn btn-sm btn-info" title="Selection"><i class="fa fa-money"></i></a>';
                }
                if (!$query->has_price_collection_selected) {
                    $btn .= '<a href="' . route('rf-quotation.edit', $query->id) . '" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-edit"></i></a>';
                    $btn .= '<button type="button" class="btn btn-sm btn-danger" onclick="deleteData(' . $query->id . ')" title="Delete"><i class="fa fa-trash"></i></button>';
                }
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->setRowId('id')
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\RequestedQuotation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RequestedQuotation $model): QueryBuilder
    {
        return $model->newQuery()->with('priceCollection');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('rf-quotation-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0, 'asc')
            ->dom("<'top'<'left-col'l><'center-col'B><'right-col'f>>rtip")
            ->setTableAttributes([
                'class' => 'table custom-table-border',
            ])
            ->selectStyleSingle()
            ->parameters([
                'responsive' => true,
                'autoWidth' => false,
                'headerCallback' => 'function(thead, data, start, end, display) {
                    $(thead).addClass("bg-smoke");
                }',
                'initComplete' => 'function(settings, json) {
                     $(settings.nTable).removeClass("table-striped table-bordered ");
                }',
                'lengthMenu' => [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
            ])
            ->buttons([
                // Button::make('excel'),
                // Button::make('csv'),
                // Button::make('pdf'),
                // Button::make('print'),
                // Button::make('reset'),
                // Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('SL')->searchable(false)->orderable(false)->width(30)->addClass('text-center'),
            Column::make('rfq_no')->title('RFQ No'),
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
    protected function filename(): string
    {
        return 'RequestedQuotation_' . date('YmdHis');
    }
}
