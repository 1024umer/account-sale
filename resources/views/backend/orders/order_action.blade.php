
@if ($row->status == 'success')
<div class="btn-group">
  <button class="btn btn-sm btn-primary details-btn"
      data-id="{{ $row->id }}" data-toggle="modal" data-target="#restockModal">Restock</button>
</div>
@else
-
@endif

