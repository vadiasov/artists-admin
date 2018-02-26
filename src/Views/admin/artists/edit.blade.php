@extends('layouts.admin.main')

@section('title', 'Artists')

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.1.0/croppie.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .example-modal .modal {
            position: relative;
            top: auto;
            bottom: auto;
            right: auto;
            left: auto;
            display: block;
            z-index: 1;
        }

        .example-modal .modal {
            background: transparent !important;
        }
    </style>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Create Artist</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin/artists') }}"><i class="fa fa-dashboard"></i> Artists</a></li>
                <li><a href="#">Edit Artist</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border" style="margin-bottom: 10px">
                            <h3 class="box-title">Edit Artist</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">

                            @foreach ($errors->all() as $error)
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-6 alert alert-danger">{{ $error }}</div>
                                </div>
                            @endforeach

                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Name</label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="name"
                                               placeholder="Name (only letters, digits, defis, apostrophe, space)"
                                               value="{{ old('name') ? old('name') : $artist->name}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Contact e-mail</label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="email"
                                               placeholder="Contact e-mail"
                                               value="{{ old('email') ? old('email') : $artist->email }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">URL Segment</label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="url"
                                               placeholder="URL Segment (not uppercase letters, defis)"
                                               value="{{ old('url') ? old('url') : $artist->url  }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Location</label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="location"
                                               placeholder="Location (city, country)"
                                               value="{{ old('location') ? old('location') : $artist->location  }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Genre</label>

                                    <div class="col-sm-9">
                                        <select class="form-control" name="genre_id">
                                            <option value="">Choose Genre</option>
                                            @foreach($genres as $key=>$genre)
                                                <option value="{{ $key }}"
                                                        @if(old('genre_id') == $genre->id or $artist->genre_id == $genre->id) selected="selected" @endif >
                                                    {!! $genre->name !!}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Tags</label>
                                    <?php
                                    if (old('genres')) {
                                        $arrayJs = '[' . implode(",", old('genres')) . ']';
                                    }
                                    ?>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" multiple="multiple"
                                                data-placeholder="Select Tags" name="tags[]"
                                                style="width: 100%;">
                                            @foreach($tags as $key=>$tag)
                                                <option value="{{ $key }}">{{ $tag->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Bio</label>
                                    <div class="col-sm-9">
                                        <div class="box-body pad">
                                            <textarea id="editor1" name="editor1" rows="10"
                                                      cols="80">{{ old('bio') ? old('bio') : $artist->bio }}</textarea>
                                        </div>
                                    </div>
                                    <!-- /.box -->
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Websites</label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="websites"
                                               placeholder="Websites (through comma)"
                                               value="{{ old('websites') ? old('websites') : $artist->websites }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Facebook account</label>

                                    <div class="col-sm-9">
                                        <input type="url" class="form-control" name="facebook"
                                               placeholder="Facebook account"
                                               value="{{ old('facebook') ? old('facebook') : $socialLinks->fb }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">LinkedIn account</label>

                                    <div class="col-sm-9">
                                        <input type="url" class="form-control" name="linkedin"
                                               placeholder="LinkedIn account"
                                               value="{{ old('linkedin') ? old('linkedin') : $socialLinks->li }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Instagram account</label>

                                    <div class="col-sm-9">
                                        <input type="url" class="form-control" name="instagram"
                                               placeholder="Instagram account"
                                               value="{{ old('instagram') ? old('instagram') : $socialLinks->in }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Google account</label>

                                    <div class="col-sm-9">
                                        <input type="url" class="form-control" name="google"
                                               placeholder="Google account"
                                               value="{{ old('google') ? old('google') : $socialLinks->go  }}">
                                    </div>
                                </div>

                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <a href="{{ route('admin/artists') }}" class="btn btn-default">Cancel</a>
                                    <button type="submit" class="btn btn-info pull-right">Save</button>
                                </div>
                                <!-- /.box-footer -->
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.col -->

                <div class="col-md-3">
                    <div class="box box-info">
                        <div class="box-header with-border" style="margin-bottom: 10px">
                            <h3 class="box-title">Artist Photo</h3>
                        </div>
                        <div class="box-body" id="upload-demo-i">
                            <img style="margin-left: auto; margin-right: auto; display: block;"
                                 src="{{ $artist->profile_picture == '' ? asset('admin/dist/img/avatar5.png') : asset('storage/artists/' . $artist->profile_picture) }}"
                                 alt="">
                        </div>
                        <div class="box-footer">
                            <a type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal">
                                Change Photo
                            </a>
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

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Upload and Crop your Picture</h4>
                </div>
                <div class="modal-body">


                    <div class="row">
                        <div class="col-md-8 text-center">
                            <div id="upload-demo" style="width:350px">

                            </div>
                        </div>
                        <div class="col-md-4" style="padding-top:30px;">
                            <strong>Select Image:</strong>
                            <br/>
                            <input type="file" id="upload">
                            <br/>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-success upload-result" data-dismiss="modal">Upload Image</button>
                </div>
            </div>
        </div>
    </div>

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
    <!-- CK Editor -->
    <script src="{{ asset('admin/bower_components/ckeditor/ckeditor.js') }}"></script>
    <!-- page script -->
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();


            $('#example1').DataTable()
            $('#example2').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false
            })

            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('editor1')
        })

        //        $('.select2').val(["1","2"]);
        $('.select2').val({{ $arrayJs }});
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.1.0/croppie.min.js"></script>
    <script>
        $('#myModal').modal({
            show: false
        })
    </script>
    <script type="text/javascript">


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $uploadCrop = $('#upload-demo').croppie({
            enableExif: true,
            viewport: {
                width: 200,
                height: 200,
                type: 'square'
            },
            boundary: {
                width: 300,
                height: 300
            }
        });


        $('#upload').on('change', function () {
            var reader = new FileReader();
            reader.onload = function (e) {
                $uploadCrop.croppie('bind', {
                    url: e.target.result
                }).then(function () {
                    console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(this.files[0]);
        });


        $('.upload-result').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {
                $.ajax({
                    url: "/image-crop/artists/" + "<?php echo $artist->id ?>",
                    type: "POST",
                    data: {"image": resp},
                    success: function (data) {
                        $("#upload-demo-i").html("");
                        html = '<img src="' + resp + '" />';
                        $("#upload-demo-i").html(html);
                    }
                });
            });
        });


    </script>
@endsection