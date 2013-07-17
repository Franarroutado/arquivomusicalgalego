@extends('master')

@section('breadcrumbs', Breadcrumbs::render('autores'))

@section('content')
  <div class="btn-toolbar">
  <div class="btn-group">
      
      <a href="{{ route('dashboard.autores.create') }}" class="btn btn-primary"><i class="icon-plus"></i> @lang('button.new_entity', array('entity' => trans('button.author')))</a>
  </div>
</div>
<div class="well">
    {{ Form::open(array('route' => 'dashboard.autores.index', 'method' => 'GET', 'id' => 'searchForm', 'class' => 'navbar-search .pull-right')) }}
      <input id="txtSearch" type="text" class="search-query" placeholder="@lang('button.search')">
    </form>
    <table class="table">
      <thead>
        <tr>
          <th>@lang('app.authors.author')</th>
          <th>@lang('app.authors.created_by')</th>
          <th style="width: 26px;"></th>
        </tr>
      </thead>
      <tbody>
        @if (count($autores) > 0)
          @foreach ($autores as $autor)
            <tr>
              <td>{{ $autor->nombre }}</td>
              <td>{{ $autor->user->first_name }}</td>
              <td>
                <div class="btn-toolbar">
                  <div class="btn-group">
                    <a class="btn btn-info" href="{{ route('dashboard.autores.edit', $autor->id) }}"><i class="icon-pencil"></i> </a>
                    <a class="btn btn-info" href="#myModal" class="deleteLink" data-id="{{ $autor->id }}" role="button" data-toggle="modal"><i class="icon-remove"></i> </a>
                  </div>
                </div>
              </td>
            </tr>
          @endforeach
        @else
          <tr>
            <td>@lang('app.msg.no_results')</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        @endif
      </tbody>
    </table>
</div>
  <div class="btn-toolbar">
    <a href="{{ route('dashboard.autores.create') }}" class="btn btn-primary"><i class="icon-plus"></i> @lang('button.new_entity', array('entity' => trans('button.author')))</a>
  <div class="btn-group">
  </div>
</div>
<div class="pagination">
    {{ $autores->links() }}
</div>

<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">@lang('button.modal.barTitle')</h3>
  </div>
  <div class="modal-body">
    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>@lang('button.modal.delteMsg', array('entity' => strtolower(trans('button.author'))))</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">@lang('button.cancel')</button>
    <a id="lnkDelete" class="btn btn-danger" data-method="DELETE"  href="{{ route('dashboard.autores.index')}}">@lang('button.delete')</a>
  </div>
</div>
{{-- This script is neccesary for allowing links use DELETE verb  --}}
{{ HTML::script('assets/js/restfulizer.js') }}

<script>
  $(document).ready(function(){
    $('#searchForm').on('submit', function(){

      var $criteria = $('#txtSearch')
      if ($criteria.val().length > 0)
      {
        var $this = $(this);
        var oldAction = $this.attr('action') + '/';
        $this.attr('action', oldAction + $criteria.val().toLowerCase() + '/search');
      }
    });
    $('.deleteLink').on('click', function(){
      var $modalForm =$('#restForm');
      var newAction = $modalForm.attr('action') + '/' + $(this).data('autor');
      $modalForm.attr('action', newAction);
    });
  });
</script>

@stop