<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <p>
        Apakah anda yakin akan mengubah paket ini?
    </p>
    <form method="POST" action="{{ route('dashboard.admin.price-list.update',['id' => $price->id]) }}" id="form-submit">
        @csrf
        @method('put')
        <div class="form-group">
            <label>Paket</labeL>
            <input class="form-control" placeholder="Bronze" name="package" value="{{ $price->package }}">
        </div>
        <div class="form-group">
            <label>Harga</labeL>
            <input class="form-control" type="text"
                   name="price" value="{{ $price->price }}">
        </div>
        <div class="form-group">
            <label>Deskripsi</labeL>
            <textarea class="form-control" name="description" style="height: 100px;">{{ $price->description }}</textarea>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
    <button type="button" class="btn btn-primary"
            onclick="event.preventDefault(); document.getElementById('form-submit').submit();">
        Ya
    </button>
</div>
