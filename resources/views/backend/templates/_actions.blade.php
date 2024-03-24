<div class="btn-group">
  {{-- <button class="btn {{ $st }} btn-sm change-status-btn"
      data-id="{{ $row->id }}">{{ $status }}</button>
      <button class="btn {{ $st }} btn-sm btn-primary details-btn"
      data-id="{{ $row->id }}">Details</button> --}}
  <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $row->id }}">Delete</button>

</div>

{{-- <div class="btn-group">
@if ($row->product_status == 'sold')
<span class="badge bg-danger text-white">Restock</span>
@endif
</div> --}}
