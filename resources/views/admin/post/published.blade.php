@extends('layouts.admin')
@section('title', 'Post \ Published - Admin Page')
@section('wrapper-header-title', 'Postingan Diterbitkan')


@section('wrapper-header-breadcrumb')
  <li class="breadcrumb-item">Admin</li>
  <li class="breadcrumb-item">Postingan</li>
  <li class="breadcrumb-item active">Diterbitkan</li>
@endsection


@section('content')
	<div class="row">
       	<div class="col-lg-12">

       		<div class="" style="margin-bottom: 25px;text-align: right;">
			    <select class="form-control form-control-sm col-2" id="filter-category" style="float: left;margin-right: 10px;">
			    	<option value="0">Semua Kategori</option>
				    @foreach ($all_category as $category)
				    	<option value="{{ $category->id }}">{{ $category->name }}</option>
				    @endforeach
				</select>

				<select class="form-control form-control-sm col-2" id="filter-author" style="float: left;">
					<option value="0">Post Saya</option>
					<option value="1">Post Semua Author</option>
				</select>

       			<a href="{{ route('admin.post.create') }}" class="btn btn-success btn-sm">
       				<i class="fa fa-plus"></i> Tambah Post
       			</a>
       			<a href="javascript:void();" id="btn-relaod" class="btn btn-primary btn-sm">
       				<i class="fa fa-refresh"></i>
       			</a>
       			<a href="" class="btn btn-danger btn-sm">
       				<i class="fa fa-download"></i>
       			</a>
       			<a href="" class="btn btn-danger btn-sm">
       				<i class="fa fa-upload"></i>
       			</a>
       		</div>

       		<div class="card">
       			<div class="card-body">

		        	<table class="table table-hover datatables table-sm" id="table">
		        		<thead>
		        			<tr>
		        				<th>#</th>
		        				<th>Judul</th>
		        				<th>Kategori</th>
		        				<th>Dibuat</th>
		        				<th>Aksi</th>
		        			</tr>
		        		</thead>
		        	</table>

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
			var oTable = $('#table').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: '',
					data: function(d){
						d.category = $('#filter-category').val();
						d.author = $('#filter-author').val();
					},
				},
				columns: [
					{data: 'no', name: 'no'},
					{data: 'title', name: 'title'},
					{data: 'category', name: 'category', orderable: false, searchable: false},
					{data: 'created_at', name: 'created_at', searchable: false},
					{data: 'action', name: 'action', orderable: false, searchable: false},
				],
			});
    		
    		$("#filter-category").on('change', function() {
    			oTable.ajax.reload();
    		});
    		$("#filter-author").on('change', function() {
    			oTable.ajax.reload();
    		});
    		$("#btn-relaod").on('click', function() {
    			oTable.ajax.reload();
    		});
		});

		
	</script>
@endpush