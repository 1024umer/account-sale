<div class="btn-group">
    <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $row->id }}">Delete</button>
    @if($row->status == 'open')
    <button class="btn btn-sm btn-success answer-btn" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $row->id }}">Answer</button>
    @endif
    <button class="btn btn-sm btn-warning details-btn" data-id="{{ $row->id }}">Details</button>
</div>
