@extends ('backend.layouts.master')

@section ('title', trans('labels.backend.maps..management') . ' | ' . trans('labels.backend.maps.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.maps.management') }}
        <small>{{ trans('labels.backend.maps.create') }}</small>
    </h1>
@endsection

@section('content')
    {!! Form::open(['route' => 'admin.maps.create', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.maps.create') }}</h3>
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('name', trans('validation.attributes.backend.maps.name'), ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.maps.name')]) !!}
                    </div>
                </div><!--form control-->

                <div class="form-group">
                    {!! Form::label('description', trans('validation.attributes.backend.maps.description'), ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.maps.description')]) !!}
                    </div>
                </div><!--form control-->

                <div class="form-group">
                    {!! Form::label('kml_file_url', trans('validation.attributes.backend.maps.file'), ['class' => 'col-lg-2 control-label', 'placeholder' => trans('validation.attributes.backend.maps.file')]) !!}
                    <div class="col-lg-10">
                        {!! Form::file('kml_file_url', ['class' => 'form-control']) !!}
                    </div>
                </div><!--form control-->

                <div class="form-group">
                    <label class="col-lg-2 control-label">{{ trans('validation.attributes.backend.maps.associated_users') }}</label>
                    <div class="col-lg-3">
                        @if (count($users) > 0)
                            @foreach($users as $user)
                                <input type="checkbox" value="{{$user->id}}" name="assignees_users[]" id="user-{{$user->id}}" /> <label for="user-{{$user->id}}">{!! $user->name !!}</label>
                                <br/>
                            @endforeach
                        @else
                            {{ trans('labels.backend.access.maps.no_users') }}
                        @endif
                    </div>
                </div><!--form control-->
            </div><!-- /.box-body -->
        </div><!--box-->

        <div class="box box-info">
            <div class="box-body">
                <div class="pull-left">
                    <a href="{!!url('admin/maps/all')!!}" class="btn btn-danger btn-xs">{{ trans('buttons.general.cancel') }}</a>
                </div>

                <div class="pull-right">
                    <input type="submit" class="btn btn-success btn-xs" value="{{ trans('buttons.general.crud.create') }}" />
                </div>
                <div class="clearfix"></div>
            </div><!-- /.box-body -->
        </div><!--box-->

    {!! Form::close() !!}
@stop
