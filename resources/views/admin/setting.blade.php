@extends('layouts.admin')
@section('title', 'Setting - Admin Page')
@section('wrapper-header-title', 'Pengaturan')


@section('wrapper-header-breadcrumb')
  <li class="breadcrumb-item">Admin</li>
  <li class="breadcrumb-item active">Pengaturan</li>
@endsection


@section('content')
  <hr>
  <div class="row">
    <div class="col-lg-12">
      <div style="margin-bottom: 25px;height: 25px;">
        <a href="" class="btn btn-success btn-sm float-right">
          <i class="fa fa-save"></i>
          Simpan
        </a>
      </div>

      <div class="card collapsed-card">
        <div class="card-header">
          <h3 class="card-title">Umum</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse">
              <i class="fa fa-plus"></i>
            </button>
          </div>
        </div>
        <div class="card-body" style="display: none;padding: 25px;">

          <form>
            <div class="form-group col-lg-4 col-sm-12">
              <label for="title">Judul Web</label>
              <input type="text" name="title" id="title" class="form-control">
            </div>
            <div class="form-group col-lg-4 col-sm-12">
              <label for="author">Pemilik Web</label>
              <input type="text" name="author" id="author" class="form-control">
            </div>
            <div class="form-group col-lg-4 col-sm-12">
              <label for="address">Alamat Pemilik</label>
              <input type="text" name="address" id="address" class="form-control">
            </div>
            <div class="form-group col-lg-4 col-sm-12">
              <label for="email">Email Pemilik</label>
              <input type="text" name="email" id="email" class="form-control">
            </div>
            <div class="form-group col-lg-4 col-sm-12">
              <label for="description">Deskripsi Web</label>
              <textarea name="description" id="description" class="form-control"></textarea>
            </div>
          </form>

        </div>
      </div>

      <div class="card collapsed-card">
        <div class="card-header">
          <h3 class="card-title">Mail</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse">
              <i class="fa fa-plus"></i>
            </button>
          </div>
        </div>
        <div class="card-body" style="display: none;padding: 25px;">

          <form>
            <div class="form-group col-lg-4 col-sm-12">
              <label for="mail_driver">Driver</label>
              <input type="text" name="mail_driver" id="mail_driver" class="form-control">
            </div>
            <div class="form-group col-lg-4 col-sm-12">
              <label for="mail_host">Host</label>
              <input type="text" name="mail_host" id="mail_host" class="form-control">
            </div>
            <div class="form-group col-lg-4 col-sm-12">
              <label for="mail_port">Port</label>
              <input type="text" name="mail_port" id="mail_port" class="form-control">
            </div>
            <div class="form-group col-lg-4 col-sm-12">
              <label for="mail_username">Username</label>
              <input type="text" name="mail_username" id="mail_username" class="form-control">
            </div>
            <div class="form-group col-lg-4 col-sm-12">
              <label for="mail_password">Password</label>
              <input type="password" name="mail_password" id="mail_password" class="form-control">
            </div>
            <div class="form-group col-lg-4 col-sm-12">
              <label for="mail_encryption">Encryption</label>
              <input type="text" name="mail_encryption" id="mail_encryption" class="form-control">
            </div>
          </form>

        </div>
      </div>


      <div class="card collapsed-card">
        <div class="card-header">
          <h3 class="card-title">Other</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse">
              <i class="fa fa-plus"></i>
            </button>
          </div>
        </div>
        <div class="card-body" style="display: none;padding: 25px;">
          <button class="btn btn-block btn-warning btn-sm">
            <i class="fa fa-trash"></i>
            Reset Semua Pengaturan Ke Semula
          </button>
          <button class="btn btn-block btn-danger btn-sm">
            <i class="fa fa-refresh"></i>
            Jalankan Ulang "SETUP INSTALLATION VIFA CMS"
          </button>
        </div>
      </div>
    


    </div>
  </div>
@stop