<div class="btn-group">
    <button class="btn {{ $st }} btn-sm change-status-btn"
        data-id="{{ $row->id }}">{{ $status == 'active' ? 'Activate': 'Inactivate' }}</button>
    <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $row->id }}">Delete</button>
</div>
