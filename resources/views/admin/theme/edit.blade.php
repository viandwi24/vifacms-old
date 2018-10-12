@extends('layouts.admin')
@section('title', 'Theme \ Edit - Admin Page')

@section('wrapper-header-title')
  Edit Tema - {{ $name }}
@stop


@section('wrapper-header-breadcrumb')
  <li class="breadcrumb-item">Admin</li>
  <li class="breadcrumb-item">Tema</li>
  <li class="breadcrumb-item active">Edit</li>
@endsection


@section('content')
  <div class="row">
    <div class="col-lg-12">
            <form action="{{ route('admin.theme.update', ['a'=>'edit_theme']) }}" method="POST">
              @csrf
              @method('PATCH')
              <input type="hidden" name="id" value="{{ $id }}">
              <input type="hidden" name="page" value="{{ $page }}">
              <div class="card">
                <div class="card-body">
                  <button type="submit" class="btn btn-success" style="margin-bottom: 25px;">
                    <i class="fa fa-save"></i>
                    Simpan
                  </button>
                  <a href="{{ route('admin.theme.index') }}" class="btn btn-danger" style="margin-bottom: 25px;">
                    <i class="fa fa-times"></i>
                    Kembali
                  </a>
                  <textarea id="theme" name="theme" style="width: 100%;height: 50vh;">{{ $theme }}</textarea>
                </div>
              </div>
            </form>
    </div>
  </div>
@stop


@push('custom-js')
  <script src="{{ url('assets/vendor/codemirror/lib/codemirror.js') }}"></script>
  <script src="{{ url('assets/vendor/codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>
  <script src="{{ url('assets/vendor/codemirror/addon/selection/selection-pointer.js') }}"></script>
  <script src="{{ url('assets/vendor/codemirror/mode/xml/xml.js') }}"></script>
  <script src="{{ url('assets/vendor/codemirror/mode/javascript/javascript.js') }}"></script>
  <script src="{{ url('assets/vendor/codemirror/mode/css/css.js') }}"></script>
  <script src="{{ url('assets/vendor/codemirror/mode/vbscript/vbscript.js') }}"></script>
  <script src="{{ url('assets/vendor/codemirror/addon/selection/active-line.js') }}"></script>


  <script type="text/javascript">
    var mixedMode = {
        name: "htmlmixed",
        scriptTypes: [{matches: /\/x-handlebars-template|\/x-mustache/i,
                       mode: null},
                      {matches: /(text|application)\/(x-)?vb(a|script)/i,
                       mode: "vbscript"}]
      };
    var editor = CodeMirror.fromTextArea(document.getElementById("theme"), {
      mode: mixedMode,
      selectionPointer: true,
      styleActiveLine: true,
      lineNumbers: true,
      lineWrapping: true
    });
    $('#theme').css({'border': '1px solid black'});
  </script>
@endpush

@push('custom-css')
  <link rel="stylesheet" href="{{ url('assets/vendor/codemirror/lib/codemirror.css') }}">
@endpush


