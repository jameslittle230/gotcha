@if (Session::has('flash_notification.message'))
    <div class="alert alert-{{ Session::get('flash_notification.level') }}">
        {{ Session::get('flash_notification.message') }}
    </div>
@endif