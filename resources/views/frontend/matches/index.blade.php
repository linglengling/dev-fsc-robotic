@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('match_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.matches.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.match.title_singular') }}
                        </a>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                            {{ trans('global.app_csvImport') }}
                        </button>
                        @include('csvImport.modal', ['model' => 'Match', 'route' => 'admin.matches.parseCsvImport'])
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.match.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Match">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.match.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.match.fields.season') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.match.fields.field') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.match.fields.time') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.match.fields.red_score') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.match.fields.blue_score') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.match.fields.is_finished') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.match.fields.n_o') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($matches as $key => $match)
                                    <tr data-entry-id="{{ $match->id }}">
                                        <td>
                                            {{ $match->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $match->season->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $match->field ?? '' }}
                                        </td>
                                        <td>
                                            {{ $match->time ?? '' }}
                                        </td>
                                        <td>
                                            {{ $match->red_score ?? '' }}
                                        </td>
                                        <td>
                                            {{ $match->blue_score ?? '' }}
                                        </td>
                                        <td>
                                            <span style="display:none">{{ $match->is_finished ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $match->is_finished ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            {{ $match->n_o ?? '' }}
                                        </td>
                                        <td>
                                            @can('match_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.matches.show', $match->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('match_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.matches.edit', $match->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('match_delete')
                                                <form action="{{ route('frontend.matches.destroy', $match->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
                                            @endcan

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('match_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.matches.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Match:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection