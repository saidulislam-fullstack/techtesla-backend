<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use App\Models\RequestedQuotation;
use Yajra\DataTables\EloquentDataTable;
use App\Models\RequestedQuotationDetail;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class RequestedQuotationReportDataTable extends DataTable
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
            ->editColumn('rfq_no', function ($query) {
                return $query->requestedQuotation?->rfq_no;
            })
            ->editColumn('date', function ($query) {
                return $query->requestedQuotation?->date;
            })
            // ->addColumn('action', function ($query) {
            //     $btn = '';
            //     $btn .= '<div class="btn-group">';
            //     $btn .= '<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . trans("file.action") . '
            //                 <span class="caret"></span>
            //                 <span class="sr-only">Toggle Dropdown</span>
            //             </button>';
            //     $btn .= '<ul class="dropdown-menu dropdown-menu-right dropdown-default" user="menu">';
            //     $btn .= '<li><a href="' . route('rf-quotation.show', $query->id) . '" class="btn btn-link" title="View"><i class="dripicons-preview"></i> ' . trans("file.View") . '</a></li>';
            //     if ($query->priceCollection->count() > 0) {
            //         $btn .= '<li><a href="' . route('price-collection.selection', $query->id) . '" class="btn btn-link" title="Selection"><i class="fa fa-check"></i> ' . trans("file.Selection") . '</a></li>';
            //     }
            //     if (! $query->has_price_collection_selected) {
            //         $btn .= '<li><a href="' . route('rf-quotation.edit', $query->id) . '" class="btn btn-link" title="Edit"><i class="dripicons-document-edit"></i> ' . trans("file.edit") . '</a></li>';
            //         $btn .= '<li><button type="button" class="btn btn-link" onclick="deleteData(' . $query->id . ')" title="Delete"><i class="dripicons-trash"></i> ' . trans("file.delete") . '</button></li>';
            //     }
            //     $btn .= '</ul>';
            //     $btn .= '</div>';
            //     return $btn;
            // })
            // ->rawColumns(['action'])
            ->setRowId('id')
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\RequestedQuotation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RequestedQuotationDetail $model): QueryBuilder
    {
        $date_range = $this->request()->get('date_range');
        $start_date = null;
        $end_date = null;
        if ($date_range) {
            $date_range = explode(' To ', $date_range);
            $start_date = date('Y-m-d', strtotime($date_range[0]));
            $end_date = date('Y-m-d', strtotime($date_range[1]));
        }
        return $model->newQuery()
            ->whereHas('requestedQuotation', function ($query) use ($start_date, $end_date) {
                // Apply date range filter if dates are provided
                $query->when($start_date, function ($query) use ($start_date, $end_date) {
                    $query->whereBetween('date', [$start_date, $end_date]);
                });
            })
            ->with([
                'product' => function ($query) {
                    $query->with('brand:id,title')->select('id', 'name', 'model', 'brand_id', 'origin');
                },
                'requestedQuotation' => function ($query) use ($start_date, $end_date) {
                    $query->when($start_date, function ($query) use ($start_date, $end_date) {
                        $query->whereBetween('date', [$start_date, $end_date]);
                    })->select('id', 'rfq_no', 'date');
                },
            ]);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('rf-quotation-report-table')
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
            Column::make('product_name')->data('product.name')->title('Product Name'),
            Column::make('product_model')->data('product.model')->title('Product Model'),
            Column::make('product_brand')->data('product.brand.title')->title('Product Brand'),
            Column::make('product_origin')->data('product.origin')->title('Product Origin'),
            Column::make('date')->title('Date'),
            // Column::computed('action')
            //     ->exportable(false)
            //     ->printable(false)
            //     ->width(60)
            //     ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'RequestedQuotationReport_' . date('YmdHis');
    }
}
