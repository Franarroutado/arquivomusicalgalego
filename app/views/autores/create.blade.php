@extends('master')

{{-- Breadcrumb --}}
@section('breadcrumbs', Breadcrumbs::render('autoresCreate'))

{{-- Content --}}
@section('content')
  <div class="container-fluid">
    <div class="row-fluid">
      {{ Form::open(array('method' => 'POST', 'route' => array('dashboard.autores.store'))) }}
        <div class="btn-toolbar">
          <button class="btn btn-primary"><i class="icon-save"></i> {{ trans('button.save') }}</button>
          <a href="{{ route('dashboard.autores.index')  }}" class="btn">@lang('button.cancel')</a>
          <div class="btn-group"></div>
        </div>
        <div class="well">
          {{ Form::label('nombre', trans('app.authors.name').":") . AMG::displayErr($errors, 'nombre') }}
          {{ Form::text('nombre',null, array('class' => 'input-xlarge')) }}
          {{ Form::label('username', trans('app.authors.created_by').":") }}
          {{ Form::text('username', Sentry::getUser()->first_name, array('class' => 'input-xlarge', 'disabled')) }}
          {{ Form::label('created_at', trans('app.authors.created_at').":") }}
          {{ Form::text('created_at',null, array('class' => 'input-xlarge', 'disabled')) }}
        </div>
        <div class="btn-toolbar">
          <button class="btn btn-primary"><i class="icon-save"></i> {{ trans('button.save') }}</button>
          <a href="{{ route('dashboard.autores.index')  }}" class="btn">@lang('button.cancel')</a>
          <div class="btn-group"></div>
        </div>
      </form>
    </div>
  </div>
@stop