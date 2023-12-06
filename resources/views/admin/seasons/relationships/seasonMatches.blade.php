<div class="content">
    @can('match_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.matches.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.match.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.match.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">

                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-seasonMatches">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
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

                                        </td>
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
                                            {{ $match->red_score ?? '' }}  <br>
                                            <span style="font-size: 10px;font-weight: bold;background-color: yellow;">
                                           <?php  //echo  $match->matchMatchTeams()->redteam()->get();
//                                                $matchMatchTeams = App\Models\MatchTeam::with('products' => function($query) {
//                                                        $query->where('isGlobal', 1);
//                                                    })->get();
                                           foreach ($match->matchMatchTeams()->redteam()->get() as $t) {
                                               echo $t->team->name."(". $t->team->n_order.") "."  -  ";
                                           }
                                           
                                           ?>
                                            </span>
<!--                                            @foreach ($match->matchMatchTeams()->redteam()->get() as $r_t)
                                                    <span>{{$r_t->name}} - </span>
                                                    
                                                  @endforeach-->
                                        </td>
                                        <td>
                                            {{ $match->blue_score ?? '' }}
                                            <br>
                                            <span style="font-size: 10px;font-weight: bold;background-color: yellow;">
                                           <?php  //echo  $match->matchMatchTeams()->redteam()->get();
//                                                $matchMatchTeams = App\Models\MatchTeam::with('products' => function($query) {
//                                                        $query->where('isGlobal', 1);
//                                                    })->get();
                                           foreach ($match->matchMatchTeams()->blueteam()->get() as $t) {
                                               echo $t->team->name ."(". $t->team->n_order.") "."  -  ";
                                           }
                                           
                                           ?>
                                            </span>
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
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.matches.show', $match->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('match_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.matches.edit', $match->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('match_delete')
                                                <form action="{{ route('admin.matches.destroy', $match->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('match_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.matches.massDestroy') }}",
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
  let table = $('.datatable-seasonMatches:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection