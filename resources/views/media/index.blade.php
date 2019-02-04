@extends('layouts.site')

@section('content')
{!! $dataTable->table() !!}

@include('media._create', ['modal_id' => 'create-modal'])
@endsection

@push('scripts')
<script src="/vendor/datatables/buttons.server-side.js"></script>
{!! $dataTable->scripts() !!}

<script lang="text/javascript">
$(document).ready(function () {
    api = $('#dataTableBuilder').DataTable();

    api.button('add:name').action(function( e, dt, button, config ) {
        $('#create-modal').modal('show');
    });
});
</script>
@endpush
