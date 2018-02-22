@extends('layouts.admin.main')

@section('title', 'Artist\'s Photo')

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet"
          href="{{ asset('admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/bower_components/select2/dist/css/select2.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/AdminLTE.min.css') }}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Artist's Photo</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin/artists') }}"><i class="fa fa-dashboard"></i> Artist's Photo</a></li>
                <li><a href="#">Edit Artist's Photo</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border" style="margin-bottom: 10px">
                            <h3 class="box-title">Edit Artist's Photo</h3>
                        </div>
                        <div class="box-body">
                            <img style="margin-left: auto; margin-right: auto; display: block;" id="image"
                                 src="{{ $artist->profile_picture == '' ? asset('admin/dist/img/avatar5.png') : '' }}"
                                 alt="">
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <form id="upload_image" data-parsley-validate class="form-horizontal form-label-left"
                                      method="post" enctype="multipart/form-data">

                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-1">
                                            <input type="file" name="photo" class="form-control col-md-6"
                                                   onchange="readURL(this)"/>
                                        </div>
                                    </div>
                                    <div class="form-group" id="next" style="visibility: hidden">
                                        <div class="col-md-11">
                                            <button type="submit" class="btn btn-info pull-right">Next</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

@section('js')
    <!-- DataTables -->
    <script src="{{ asset('admin/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('admin/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('admin/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('admin/dist/js/demo.js') }}"></script>
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {

                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image')
                        .attr('src', e.target.result)
                        .width(600);
                    $('#next').css("visibility", "visible");
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection