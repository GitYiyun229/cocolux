@if(Session::has('notification'))
    <div class="alert alert-dismissable alert-{{ session('notification')['status'] == 'success' ? 'success' : 'danger' }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ session('notification')['message'] }}
    </div>
@endif