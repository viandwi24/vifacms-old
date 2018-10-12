@extends('layouts.admin')
@section('title', 'Post \ Create')
@section('wrapper-header-title')
	@if ($page == 'create')
		Buat Post
	@elseif ($page == 'draft')
		Edit Draf
	@else
		Edit Post
	@endif
@stop

@section('wrapper-header-breadcrumb')
  <li class="breadcrumb-item">Admin</li>
  <li class="breadcrumb-item">Postingan</li>
  <li class="breadcrumb-item active">
	@if ($page == 'create')
		Buat
	@elseif ($page == 'draft')
		Edit Draf
	@else
		Edit
	@endif
</li>
@endsection

@section('content')
	<form method="POST" action="
	@if ($page == 'create')
		{{ route('admin.post.store') }}
	@else
		{{ route('admin.post.update', ['id' => $post->id]) }}
	@endif">

	@if ($page == 'edit' or $page == 'draft')
		<input type="hidden" name="_method" value="PATCH">
	@endif
	@csrf
	<div class="row">
		<div class="col-lg-9">
			<input type="text" name="title" id="title" placeholder="Judul" class="form-control form-control-sm" value="{{ @$post->title }}">
			<div style="margin-top: 10px;">
				<textarea id="article" name="article" 
					style="width: 100%;height: 40vh;"
					>@if ($page == 'create') 
						Buat Artikel Baru
					@else
						{{ @$post->article }}
					@endif</textarea>
			</div>
		</div>
		<div class="col-lg-3">
			
			<div class="card card-sm collapsed-card">
		        <div class="card-header">
		          <span class="card-title">Simpan</span>
		          <div class="card-tools">
		            <button type="button" class="btn btn-tool" data-widget="collapse">
		              <i class="fa fa-plus"></i>
		            </button>
		          </div>
		      </div>
				<div class="card-body">
					<input type="radio" name="save_type" value="publish" 
					@if ($page != 'draft')
						checked=""
					@endif
					> Terbitkan<br>
					<input type="radio" name="save_type" value="draft" 
					@if ($page == 'draft')
						checked=""
					@endif
					> Draf

					<button type="submit" class="btn btn-primary btn-xs btn-block">
						<i class="fa fa-save"></i> Simpan
					</button>
				</div>
			</div>

			<div class="card card-sm collapsed-card">
		        <div class="card-header">
		          <span class="card-title">Gambar Cover</span>
		          <div class="card-tools">
		            <button type="button" class="btn btn-tool" data-widget="collapse">
		              <i class="fa fa-plus"></i>
		            </button>
		          </div>
		        </div>
		        <div class="card-body" style="display: none;padding: 25px;">
		        </div>
		    </div>
		        
			<div class="card card-sm collapsed-card">
		        <div class="card-header">
		          <span class="card-title">Kategori</span>
		          <div class="card-tools">
		            <button type="button" class="btn btn-tool" data-widget="collapse">
		              <i class="fa fa-plus"></i>
		            </button>
		          </div>
		        </div>
		        <div class="card-body" style="display: none;padding: 25px;">
                  <select name="category[]" class="form-control select2" multiple="multiple" 
                    data-placeholder="Pilih Kategori.." placeholder="Pilih Kategori.." style="width: 100%;">
	                	<?php $post_category = [];if ($page=='edit' or $page=='draft') $post_category = json_decode($post->category);
	                	?>
	                    @foreach ($all_category as $category)	                    
	                    	<option value="{{ $category->id }}"
		                    	@if ($page=='edit' or $page='draft')
		                          @if (in_array($category->id,  $post_category))
		                            selected="" 
		                          @endif
		                    	@endif
	                    		>{{ $category->name }}</option>
	                    @endforeach
                  </select>
		        </div>
		    </div>
			<div class="card card-sm collapsed-card">
		        <div class="card-header">
		          <span class="card-title">SEO</span>
		          <div class="card-tools">
		            <button type="button" class="btn btn-tool" data-widget="collapse">
		              <i class="fa fa-plus"></i>
		            </button>
		          </div>
		        </div>
		        <div class="card-body" style="display: none;padding: 25px;">
		        	<textarea class="form-control" name="description">{{ @$post->description }}</textarea>
		        </div>
		    </div>

		</div>
	</div>
	</form>
@stop


@push('custom-js')
	<script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>

	<script type="text/javascript">
		$('body').addClass('sidebar-collapse');
    	$('.select2').select2();
		tinymce.init({ 
			selector:'textarea#article',
			
			plugins: "advlist autolink lists link charmap preview hr anchor code image codesample preview searchreplace wordcount visualblocks visualchars fullscreen insertdatetime media nonbreaking save table contextmenu directionality template paste textcolor colorpicker textpattern fullscreen emoticons print",
  			toolbar: [
  				"undo redo | vifagaleryimage codesample insert | preview spellchecker code | fullscreen",
  				"formatselect bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
  			],

			setup: function (editor) {
				editor.addButton('vifagaleryimage', {
			      text: false,
			      tooltip: 'Upload Gambar',
			      icon: 'fa fa-image',
			      onclick: function () {
			        editor.insertContent('<b>COBA</b>');
			      }
			    });
			}
		});
	</script>
@endpush


@push('custom-css')
	<link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
	<style type="text/css">
	.mce-ico.mce-i-fa {
	    display: inline-block;
	    font: normal normal normal 14px/1 FontAwesome;
	    font-size: inherit;
	    text-rendering: auto;
	    -webkit-font-smoothing: antialiased;
	    -moz-osx-font-smoothing: grayscale;
	}
	.card-sm .card-header{
		font-size: 14px;
		padding: 15px;
	}
	.card-sm .card-title{
		font-size: 14px;
	}
	.card-sm .card-body {
		padding: 15px;
	}
	</style>
@endpush