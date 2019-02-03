<?php

namespace App\DataTables;

use App\User;
use App\Models\Media;
use Yajra\DataTables\Services\DataTable;

class MediaDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query);
            // ->addColumn('action', 'mediadatatable.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Media $model)
    {
        return $model->newQuery()->select();
    }

    public function getBuilderParameters()
    {
        $conf = parent::getBuilderParameters();

        $dom = str_replace('f', '', $conf['dom']); // Remove global search
        $dom = str_replace('p', '', $dom); // remove pager temporarily so we can reposition it
        $dom = str_replace('B', '<"row"<"col-md-6"B><"col-md-6 ml-auto"f>>', $dom);
        $dom = str_replace('i', '', $dom);
        $dom .= "p";
        $conf['dom'] = $dom;

        $conf['pageLength'] = 20;
        $conf['fixedHeader'] = true;

        $conf['buttons'] = ['csv', ['extend' => 'colvis', 'text' => 'Columns <b class="caret"></b>']];

        return $conf;
    } // end getBuilderParameters

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            // ->addAction(['width' => '80px'])
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
            ['title' => 'ID', 'data' => 'id', 'name' => 'id', 'visible' => false],
            ['title' => 'Title', 'data' => 'title', 'name' => 'title'],
            ['title' => 'IMDB Rating', 'data' => 'imdb_rating', 'name' => 'imdb_rating'],
            ['title' => 'Released', 'data' => 'year', 'name' => 'year'],
            ['title' => 'Runtime', 'data' => 'runtime', 'name' => 'runtime'],
            ['title' => 'Added to List', 'data' => 'created_at', 'name' => 'created_at', 'render' => "data.split(' ')[0]"],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Media_' . date('YmdHis');
    }
}
