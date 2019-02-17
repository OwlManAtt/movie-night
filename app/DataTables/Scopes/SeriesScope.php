<?php

namespace App\DataTables\Scopes;

use Yajra\DataTables\Contracts\DataTableScope;

class SeriesScope implements DataTableScope
{
    protected $media_series_id;

    public function __construct(int $media_series_id)
    {
        $this->media_series_id = $media_series_id;
    }

    public function apply($query)
    {
        return $query->whereHas('series.media', function ($query) {
            $query->where('id', $this->media_series_id);
        });
    }
}
