<?php

namespace App\DataTables;

use App\Models\SeriesEpisode;
use Yajra\DataTables\Services\DataTable;

class EpisodeDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('action', 'episodedatatable.action');
    }

    public function query(SeriesEpisode $model)
    {
        return $model->newQuery()
            ->with('media');
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

        $conf['pageLength'] = 10;
        $conf['order'] = [[1, 'asc']];

        $conf['buttons'] = [
            [
                'extend' => 'colvis',
                'text' => 'Columns <b class="caret"></b>',
            ],
        ];

        return $conf;
    } // end getBuilderParameters

    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters($this->getBuilderParameters());
    }

    protected function getColumns()
    {
        return [
            ['title' => 'ID', 'data' => 'id', 'name' => 'id', 'visible' => false],
            ['title' => 'Episode Order', 'data' => 'episode_order', 'name' => 'episode_order', 'visible' => false],
            ['title' => 'Title', 'data' => 'media.title', 'name' => 'media.title'],
            ['title' => 'Season', 'data' => 'season', 'name' => 'season'],
            ['title' => 'Episode', 'data' => 'episode', 'name' => 'episode'],
            ['title' => 'Runtime', 'data' => 'media.runtime', 'name' => 'media.runtime'],
        ];
    }

    protected function filename()
    {
        return 'Episodes_' . date('YmdHis');
    }
}
