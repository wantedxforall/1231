<style>
    .actions {
        margin: 0 2px 0 2px !important;
        padding: 10px !important;
    }

    .actions i {
        padding: 0px 2px !important;
    }

</style>
@if(isset($edit))
<a title="Edit" href="{{ $edit }}" class="btn btn-primary actions"><i class="bi bi-pencil-square"></i></a>
@endif
@if(isset($show))
<a target="_blank" href="{{ $show }}" title="Show" class="btn btn-success actions"><i class="bi bi-arrow-right"></i></a>
@endif

@if(isset($review))
<a href="{{ $review }}" title="review" class="btn btn-dark actions"><i class="bi bi-arrow-right"></i></a>
@endif

@if(isset($approve))
<a title="Approve" onclick="document.getElementById('form-approve-{{ $id }}').submit()" class="btn btn-success actions" style="margin-right: 10px"><i class="fa fa-thumbs-up"></i></a>
<form id="form-approve-{{ $id }}" action="{{ $approve }}" method="POST">
    <input type="hidden" name="status" value="inprogress">
    @csrf
</form>
@endif

@if(isset($destroy))
<a title="Delete" onclick="if(confirm('Are You Sure ?')){document.getElementById('form-destroy{{ $id }}').submit()}" class="btn btn-danger actions"><i class="bi bi-trash3"></i></a>
<form id="form-destroy{{ $id }}" action="{{ $destroy }}" method="POST">
    @csrf
    @method('DELETE')
</form>
@endif

@if(isset($reject))
<a title="Reject" onclick="document.getElementById('form-reject-{{ $id }}').submit()" class="btn btn-danger actions" style="margin-right: 10px"><i class="fa fa-cancel"></i></a>
<form id="form-reject-{{ $id }}" action="{{ $reject }}" method="POST">
    <input type="hidden" name="status" value="canceled">
    @csrf
</form>
@endif

@if(isset($resend))
<a title="Resend" onclick="document.getElementById('form-resend-{{ $id }}').submit()" class="btn btn-warning actions" style="margin-right: 10px"><i class="bi bi-send"></i></a>
<form id="form-resend-{{ $id }}" action="{{ $resend }}" method="POST">
    <input type="hidden" name="status" value="resend">
    @csrf
</form>
@endif


