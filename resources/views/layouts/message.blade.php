
@if (Session::has('success'))
<div class="alert alert-success">
    {{ Session::get('success') }}
</div>
@elseif (Session::has('error'))
<div class="alert alert-danger">
    {{ Session::get('error') }}
</div>
@elseif (Session::has('info'))
<div class="alert alert-info">
    {{ Session::get('info') }}
</div>
@endif