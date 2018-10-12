@extends('layouts.default')

@push('custom-css')
	<style type="text/css">
	.brand-link {
		text-align: center;
		margin-left: -30px;
	}
	.sidebar-collapse .brand-link {
		text-align: left;
		margin-left: 0;
	}
	</style>
@endpush

@section('content-footer')
	<footer class="main-footer">
      <div class="float-right d-sm-none d-md-block">
        V1.5.0
      </div>
      <strong>Copyright &copy; 2018 VIFA by Alfian Dwi Nugraha.</strong> All rights reserved.
    </footer>
@stop

@push('content-main')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@yield('wrapper-header-title')</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              @yield('wrapper-header-breadcrumb')
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">

        @yield('content')

      </div>
  	</section>
@endpush

@section('content-header')
  @include('layouts.header-admin')
@stop