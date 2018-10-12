@extends('layouts.admin')
@section('title', 'Theme \ Manager - Admin Page')
@section('wrapper-header-title', 'Atur Tema')


@section('wrapper-header-breadcrumb')
  <li class="breadcrumb-item">Admin</li>
  <li class="breadcrumb-item">Tema</li>
  <li class="breadcrumb-item active">Atur Tema</li>
@endsection


@section('content')
  <div class="row">
    <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <form action="{{ route('admin.theme.update', ['a'=>'change_theme']) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group">
                  <label>Tema :</label>
                  <div class="row">
                    <select name="theme" class="form-control form-control-sm col-2" style="margin-right: 15px;">
                      @foreach ($all_theme as $tm)
                        @if ($tm->id == $theme->id)
                          <option value="{{ $tm->id }}" selected="">{{ $tm->name }}</option>
                        @else
                          <option value="{{ $tm->id }}">{{ $tm->name }}</option>
                        @endif
                      @endforeach
                    </select>
                    <button class="btn btn-primary btn-xs" style="margin-right: 5px;">
                      <i class="fa fa-paper-plane"></i>
                      Terapkan
                    </button>
                    <button class="btn btn-success btn-xs" style="margin-right: 5px;">
                      <i class="fa fa-plus"></i>
                      Buat
                    </button>
                    <button class="btn btn-danger btn-xs" style="margin-right: 5px;">
                      <i class="fa fa-cog"></i>
                      Pasang
                    </button>
                    <button class="btn btn-danger btn-xs">
                      <i class="fa fa-upload"></i>
                      Ekspor
                    </button>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-2">
                      <b>Tema Aktif</b><br>
                      <b>Author</b><br>
                      <b>Versi</b>
                    </div>
                    <div class="col-6">
                      : {{ $theme->name }}<br>
                      : {{ $theme->author }}<br>
                      : {{ $theme->version }}
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>


          <div class="card">
            <div class="card-body">
              <h3>Kustomisasi</h3><hr>
              <table class="table table-hover table-sm" id="table">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Home</td>
                    <td>
                      <a href="{{ route('admin.theme.edit', ['id' => $theme->id, 'page' => 'home']) }}" class="btn btn-xs btn-warning">
                        <i class="fa fa-pencil"></i>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td>Post</td>
                    <td>
                      <a href="{{ route('admin.theme.edit', ['id' => $theme->id, 'page' => 'post']) }}" class="btn btn-xs btn-warning">
                        <i class="fa fa-pencil"></i>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td>Search</td>
                    <td>
                      <a href="{{ route('admin.theme.edit', ['id' => $theme->id, 'page' => 'search']) }}" class="btn btn-xs btn-warning">
                        <i class="fa fa-pencil"></i>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td>Erorr 404</td>
                    <td>
                      <a href="{{ route('admin.theme.edit', ['id' => $theme->id, 'page' => '404']) }}" class="btn btn-xs btn-warning">
                        <i class="fa fa-pencil"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>

            </div>
        </div>

    </div>
  </div>


@stop
