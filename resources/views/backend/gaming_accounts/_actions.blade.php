<div class="btn-group">
    <button class="btn {{ $st }} btn-sm change-status-btn"
        data-id="{{ $row->id }}">{{ $status }}</button>
        <button class="btn {{ $st }} btn-sm btn-primary details-btn"
        data-id="{{ $row->id }}">Details</button>
    <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $row->id }}">Delete</button>


</div>

  @if($available_channels_count === 0)
    <div class="btn-group">
        <button class="btn btn-sm bg-danger text-white restock-btn" data-id="{{ $row->id }}">Restock</button>
    </div>
   @endif

