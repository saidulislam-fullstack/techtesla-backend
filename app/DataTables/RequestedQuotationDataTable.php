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
            // Show Customer, Type, Date, Created BY
            ->editColumn('customer', function ($query) {
                return $query->customer?->name ?? 'N/A';
            })
            ->editColumn('type', function ($query) {
                // Show Type of RFQ by ucfirst and space replace with underscore
                return ucfirst(str_replace('_', ' ', $query->type));
            })
            ->addColumn('has_purchase', function ($query) {
                return $query->purchases->count() > 0 ? 'Yes' : 'No';
            })
            ->addColumn('has_sale', function ($query) {
                if ($query->type == 'techtesla_stock') return '----';
                return $query->sales->count() > 0 ? 'Yes' : 'No';
            })
            ->editColumn('date', function ($query) {
                return $query->date;
            })
            ->editColumn('addedBy', function ($query) {
                return $query->addedBy?->name;
            })
            ->addColumn('action', function ($query) {
                $btn = '';
                $btn .= '<div class="btn-group">';
                $btn .= '<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . trans("file.action") . '
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
                $btn .= '<ul class="dropdown-menu dropdown-menu-right dropdown-default" user="menu">';
                $btn .= '<li><a href="' . route('rf-quotation.show', $query->id) . '" class="btn btn-link" title="View"><i class="dripicons-preview"></i> ' . trans("file.View") . '</a></li>';
                $btn .= '<li><a href="' . route('rf-quotation.price-quotation', $query->id) . '" class="btn btn-link" title="View"><i class="fa fa-file"></i> Price Quotation</a></li>';
                $btn .= '<li><a href="' . route('rfq-stock-check', $query->id) . '" class="btn btn-link" title="View"><i class="dripicons-swap"></i> Stock Comparison</a></li>';
                if ($query->priceCollection->count() > 0) {
                    $btn .= '<li><a href="' . route('price-collection.selection', $query->id) . '" class="btn btn-link" title="Selection"><i class="fa fa-check"></i> ' . trans("file.Selection") . '</a></li>';
                }
                $btn .= '<li><button type="button" class="btn btn-link" onclick="openOthersInfoModal(' . $query->id . ')"><i class="fa fa-edit"></i> Update Others Info</button></li>';
                if (! $query->has_price_collection_selected) {
                    $btn .= '<li><a href="' . route('rf-quotation.edit', $query->id) . '" class="btn btn-link" title="Edit"><i class="dripicons-document-edit"></i> ' . trans("file.edit") . '</a></li>';
                    $btn .= '<li><button type="button" class="btn btn-link" onclick="deleteData(' . $query->id . ')" title="Delete"><i class="dripicons-trash"></i> ' . trans("file.delete") . '</button></li>';
                }
                $btn .= '</ul>';
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
        return $model->newQuery()->with('priceCollection', 'customer:id,name', 'addedBy:id,name')->when(auth()->user()->role_id == 6, function ($query) {
            return $query->where('added_by', auth()->user()->id);
        })->orderBy('id', 'desc');
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
                'lengthMenu' => [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                "rowCallback" => "function(row, data, index) {
                    if (data.type === 'Techtesla stock') {
                        $(row).css('background-color', '#e5ebf6ff');
                    } else if (data.type === 'Project') {
                        $(row).css('background-color', '#dff5eeff');
                    } else if (data.type === 'Regular mro') {
                        $(row).css('background-color', '#f3ede1ff'); 
                    }
                }",
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
            Column::make('customer')->title('Customer'),
            Column::make('type')->title('Type'),
            Column::make('has_purchase')->title('PO Generated'),
            Column::make('has_sale')->title('SO Generated'),
            Column::make('date')->title('Date'),
            Column::make('addedBy')->title('Created By'),
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
