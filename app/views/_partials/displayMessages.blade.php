<div id="messages">
  @if(Session::has('success'))
      <div class="row-fluid">
          <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>{{ Session::get('success')  }}</strong> 
          </div>
      </div>
  @endif

  @if(Session::has('warning'))
      <div class="row-fluid">
          <div class="alert alert-warning">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>{{ Session::get('warning')  }}</strong> 
          </div>
      </div>
  @endif

  @if(Session::has('error'))
      <div class="row-fluid">
          <div class="alert alert-error">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>{{ Session::get('error')  }}</strong>
          </div>
      </div>
  @endif
</div>