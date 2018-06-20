@extends('adminlte::page')

@section('title', 'Feedback form')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Bordered Table</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>#</th>
                            <th>Theme</th>
                            <th>Message</th>
                            <th>User name</th>
                            <th>User mail</th>
                            <th>File</th>
                            <th>Time to create</th>
                        </tr>
                        @foreach($data as $dib)
                            <tr>
                                <td>{{$count++}}</td>
                                <td>{{$dib->theme}}</td>
                                <td>{{$dib->message}}</td>
                                <td>{{$dib->name}}</td>
                                <td><a href="mailto:{{$dib->email }}">{{$dib->email}}</a></td>
                                <td>
                                    <a href="{{url('/download?file=' . urlencode($dib->file))}}"><i class="fa fa-download" aria-hidden="true"></i> Download user file</a>
                                </td>
                                <td>{{$dib->created_at}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    {{$data->links()}}
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>

@stop