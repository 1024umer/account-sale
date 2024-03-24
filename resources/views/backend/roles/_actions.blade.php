@if($row->name == 'Super Admin' || $row->name == 'User')
@else
<button class="btn btn-sm btn-danger delete-btn mb-1" data-id="{{ $row->id }}">Delete</button>
<button class="btn btn-sm btn-primary edit-btn mb-1" data-name="{{ $row->name }}" data-id="{{ $row->id }}" data-permissions="{{ $row->rolePermissions }}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser" aria-controls="offcanvasAddUser">Edit</button>

@endif