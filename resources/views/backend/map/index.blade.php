@extends ('backend.layouts.master')

@section ('title', trans('labels.backend.access.users.management'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.maps.management') }}
    </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <div class="box-tools pull-right">
                @include('backend.map.includes.partials.header-buttons')
            </div>
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>{{ trans('labels.backend.maps.table.id') }}</th>
                        <th>{{ trans('labels.backend.maps.table.name') }}</th>
                        <th>{{ trans('labels.backend.maps.table.file') }}</th>
                        <th>{{ trans('labels.backend.maps.table.users') }}</th>
                        <th class="visible-lg">{{ trans('labels.backend.maps.table.created') }}</th>
                        <th class="visible-lg">{{ trans('labels.backend.maps.table.last_updated') }}</th>
                        <th>{{ trans('labels.general.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($maps as $map)
                            <tr>
                                <td>{!! $map->id !!}</td>
                                <td>{!! $map->name !!}</td>
                                <td>{!! link_to('kmls/' . $map->kml_file_url) !!}</td>
                                <td>
                                    @if ($map->users()->count() > 0)
                                        @foreach ($map->users as $user)
                                            {!! $user->name !!}<br/>
                                        @endforeach
                                    @else
                                        {{ trans('labels.general.none') }}
                                    @endif
                                </td>
                                <td class="visible-lg">{!! $map->created_at->diffForHumans() !!}</td>
                                <td class="visible-lg">{!! $map->updated_at->diffForHumans() !!}</td>
                                <td>{!! $map->action_buttons !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pull-left">
                {!! $maps->total() !!} {{ trans_choice('labels.backend.maps.table.total', $maps->total()) }}
            </div>

            <div class="pull-right">
                {!! $maps->render() !!}
            </div>

            <div class="clearfix"></div>
        </div><!-- /.box-body -->
    </div><!--box-->
@stop
