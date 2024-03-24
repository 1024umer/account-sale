<div class="btn-group">
    <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $row->id }}">Delete</button>
    <button class="btn btn-sm btn-primary edit-btn" data-question="{{ $row->question }}" data-answer="{{ $row->answer }}" data-id="{{ $row->id }}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser" aria-controls="offcanvasAddUser">Edit</button>
</div>
