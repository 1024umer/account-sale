<div class="btn-group">
  <a class="btn btn-sm btn-danger" href="{{ route('admin.customrefferal.refferal.edit', ['id' => $row->id]) }}">Edit</a>
  <button class="btn btn-sm btn-warning delete-btn" data-id="{{ $row->id }}">Delete</button>
</div>
