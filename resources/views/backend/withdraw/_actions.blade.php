<div class="btn-group">
    @if($row->status == 'pending')
    <button class="btn btn-sm btn-success answer-btn" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $row->id }}">Mark</button>
    @endif
</div>
