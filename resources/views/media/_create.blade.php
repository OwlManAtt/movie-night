<div class="modal" id="{{ $modal_id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Movie or Show</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id='createForm' action="{{ route('media.store' )}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="titleSearch">Movie or Show Name</label>
                        <div class="typeahead__container">
                            <div class="typeahead__field">
                                <div class="typeahead__query">
                                   <input name="title" id="titleSearch" class="form-control js-typeahead" type="search" placeholder="Search..." autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="imdbId">IMDB ID</label>
                        <input name="imdbId" type="text" class="form-control" id="imdbId" placeholder="IMDB ID Number..." readonly aria-describedby="imdbIdHelp">
                        <small id="imdbIdHelp" class="form-text text-muted">
                            This will be filled in for you when you find your movie/show on IMDB.
                        </small>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script lang="text/javascript">
$(document).ready(function () {
    $('#titleSearch').typeahead({
        debug: {{ config('app.debug') === true ? 'true' : 'false' }},
        minLength: 2,
        maxItems: 5,
        order: 'asc',
        dynamic: true,
        delay: 500,
        emptyTemplate: "No results for @{{query}}",
        template: function (query, item) {
            return '<div class="row">' +
                '<div class="col-2"><img src="@{{Poster}}" alt="" class="img-fluid"></div>' +
                '<div class="col-8">@{{Title}}</div>' +
                '<div class="col-2 ml-auto text-right"><span class="text-muted">@{{Year}}</span></div>' +
                "</div>";
        },
        source: {
            imdb: {
                display: "Title",
                ajax: {
                    type: "GET",
                    url: '{{ route('imdb-search') }}',
                    path: 'data.imdb',
                    data: {
                        title: '@{{query}}',
                    },
                }
            }
        },
        callback: {
            onClick: function (node, a, item, event) {
                $('#imdbId').val(item.imdbID)
            },
        },
    });
});
</script>
@endpush