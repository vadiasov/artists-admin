@extends('layouts.admin.main2')

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
    <!-- jcrop -->
    <link rel="stylesheet" href="{{ asset('jcrop/css/jquery.Jcrop.min.css') }}"/>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="{{ asset('jcrop/js/jquery.Jcrop.min.js') }}"></script>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Artist's Photo</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin/artists') }}"><i class="fa fa-dashboard"></i> Artist's Photo</a></li>
                <li><a href="#">Crop Artist's Photo</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="box-title">Crop Artist's Photo</h3>
                    <img style="margin-left: auto; margin-right: auto; display: block; "
                         id="cropimage"
                         src="{{ asset('storage/temp/' . $artist->profile_picture) }}">
                    <div class="row">
                        <div class="col-md-7 col-md-offset-1">
                            {{ Form::open(array('files' => true)) }}
                            {{ Form::hidden('image', $artist->image) }}
                            {{ Form::hidden('x', '', array('id' => 'x')) }}
                            {{ Form::hidden('y', '', array('id' => 'y')) }}
                            {{ Form::hidden('w', '', array('id' => 'w')) }}
                            {{ Form::hidden('h', '', array('id' => 'h')) }}
                            {{--{{ Form::submit('Crop it!') }}--}}
                            <br>
                            <button type="submit" class="btn btn-info pull-right">Crop!</button>
                            {{ Form::close() }}
                        </div>
                        {{--<div class="form-group" id="next" style="visibility: hidden">--}}
                        {{--<div class="col-md-11">--}}
                        {{--<button type="submit" class="btn btn-info pull-right">Next</button>--}}
                        {{--</div>--}}
                        {{--</div>--}}
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
    <!-- SlimScroll -->
    <script src="{{ asset('admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('admin/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('admin/dist/js/demo.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('#cropimage').Jcrop({
                onSelect: updateCoords,
                bgColor: 'white',
                bgOpacity: 1.0,
                minSize: [150, 150],
                maxSize: [300, 300],
                setSelect: [100, 100, 50, 50],
                aspectRatio: 1
            });
        });
        function updateCoords(c) {
            $('#x').val(c.x);
            $('#y').val(c.y);
            $('#w').val(c.w);
            $('#h').val(c.h);
        }
        ;
    </script>

@endsection