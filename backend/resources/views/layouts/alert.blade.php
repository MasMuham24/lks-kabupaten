@if (session($type))
    <div class="alert alert-{{ $type === 'error' ? 'danger' : $type }} alert-dismissible fade show" role="alert">
        <i
            class="bi
        @if ($type === 'success') bi-check-circle-fill text-success
        @elseif($type === 'error') bi-x-circle-fill text-danger
        @elseif($type === 'warning') bi-exclamation-triangle-fill text-warning
        @else bi-info-circle-fill text-info @endif
        me-2">
        </i>

        {{ session($type) }}

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
