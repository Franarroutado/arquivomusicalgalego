@extends('master')

{{-- Breadcrumb --}}
@section('breadcrumbs', Breadcrumbs::render('autoresEdit', $autore->id))

{{-- Content --}}
@section('content')
<div class="container-fluid">
  <div class="row-fluid">
    {{ Form::model($autore, array('method' => 'PUT', 'route' => array('dashboard.autores.update', $autore->id))) }}
    <div class="btn-toolbar">
      <button class="btn btn-primary"><i class="icon-save"></i> @lang('button.save')</button>
      <a href="{{ route('dashboard.autores.index')  }}" class="btn">@lang('button.cancel')</a>
      <a href="#myModal" data-toggle="modal" class="btn btn-warning">@lang('button.delete')</a>
      <div class="btn-group"></div>
    </div>
    <div class="well">
      {{ Form::label('nombre', trans('app.authors.name').":") . AMG::displayErr($errors, 'nombre') }}
      {{ Form::text('nombre',null, ['class' => 'input-xlarge']) }}
      {{ Form::label('nombre.user.first_name', trans('app.authors.created_by').":") }}
      {{ Form::text('user.first_name', null, ['class' => 'input-xlarge', 'disabled']) }} 
      {{ Form::label('created_at', trans('app.authors.created_at').":") }}
      {{ Form::text('created_at',null, ['class' => 'input-xlarge', 'disabled']) }}
    </div>
    <div class="btn-toolbar">
      <button class="btn btn-primary"><i class="icon-save"></i> @lang('button.save')</button>
      <a href="{{ route('dashboard.autores.index')  }}" class="btn">@lang('button.cancel')</a>
      <a href="#myModal" data-toggle="modal" class="btn btn-warning">@lang('button.delete')</a>
      <div class="btn-group"></div>
    </div>
    {{ Form::close() }}
</div>

<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">@lang('button.modal.barTitle')</h3>
  </div>
  <div class="modal-body">
    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>@lang('button.modal.delteMsg', ['entity' => strtolower(trans('button.author'))])</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">@lang('button.cancel')</button>
    <a class="btn btn-danger" data-method="DELETE"  href="{{ route('dashboard.autores.destroy', $autore->id)}}">@lang('button.delete')</a>
  </div>
</div>
{{-- This script is neccesary for allowing links use DELETE verb  --}}
{{ HTML::script('assets/js/restfulizer.js') }}
@stop