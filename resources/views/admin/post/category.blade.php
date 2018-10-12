@extends('layouts.admin')
@section('title', 'Post \ Category - Admin Page')
@section('wrapper-header-title', 'Kategori')


@section('wrapper-header-breadcrumb')
  <li class="breadcrumb-item">Admin</li>
  <li class="breadcrumb-item">Postingan</li>
  <li class="breadcrumb-item active">Kategori</li>
@endsection


@section('content')
  <div class="row">
    <div class="col-lg-12">
          <div class="" style="margin-bottom: 25px;text-align: right;">
            <button type="button" class="btn btn-success btn-sm" onclick="createNow();">
              <i class="fa fa-plus"></i>
              Tambah Kategori
            </button>
          </div>

          <div class="card">
            <div class="card-body">

              <table class="table table-hover datatables table-sm" id="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
              </table>

            </div>
        </div>

    </div>
  </div>

    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEditLabel">Edit Kategori</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('admin.post.category.update') }}" method="POST">
              @csrf
              <input type="hidden" name="_method" value="PATCH">
              <div class="form-group">
                <label>Nama :</label>
                <input type="text" class="form-control" name="name" id="category-edit">
                <input type="hidden" class="form-control" name="id" id="category-edit-id">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          </div>
        </div>
      </div>
    </div>

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('admin.post.category.store') }}" method="POST">
              @csrf
              <div class="form-group">
                <label>Nama :</label>
                <input type="text" class="form-control" name="name">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Buat</button>
            </form>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          </div>
        </div>
      </div>
    </div>


@stop


@push('custom-css')
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/DataTables/datatables.min.css') }}">
@endpush

@push('custom-js')
  <script type="text/javascript" src="{{ asset('assets//vendor/DataTables/datatables.min.js') }}"></script>

  <script type="text/javascript">
    $(document).ready(function(){

      $(function(){
        var oTable = $('#table').DataTable({
          processing: true,
          serverSide: true,
          ajax: '',
          columns: [
            {data: 'no', name: 'no'},
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
        });
      });


    });
      function editNow(idnya, namanya)
      {
        $('#category-edit').val(namanya);
        $('#category-edit-id').val(idnya);
        $('#modalEdit').modal('show');
      }
      function createNow()
      {
        $('#exampleModal').modal('show');
      }
  </script>
@endpush