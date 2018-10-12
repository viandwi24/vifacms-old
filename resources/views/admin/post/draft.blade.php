@extends('layouts.admin')
@section('title', 'Post \ Draft - Admin Page')
@section('wrapper-header-title', 'Postingan Draf')


@section('wrapper-header-breadcrumb')
  <li class="breadcrumb-item">Admin</li>
  <li class="breadcrumb-item">Postingan</li>
  <li class="breadcrumb-item active">Draf</li>
@endsection


@section('content')
	<div class="row">
       	<div class="col-lg-12">
       		<div class="card">
       			<div class="card-body">

		        	<table class="table table-hover datatables table-sm" id="table">
		        		<thead>
		        			<tr>
		        				<th>#</th>
		        				<th>Judul</th>
		        				<th>Kategori</th>
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

			$(function(){
				var oTable = $('#table').DataTable({
					processing: true,
					serverSide: true,
					ajax: '',
					columns: [
						{data: 'no', name: 'no'},
						{data: 'title', name: 'title'},
						{data: 'category', name: 'category', orderable: false, searchable: false},
						{data: 'action', name: 'action', orderable: false, searchable: false},
					],
				});
			});

		});
	</script>
@endpush