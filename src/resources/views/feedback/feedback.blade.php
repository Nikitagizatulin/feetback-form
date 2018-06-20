@extends('adminlte::page')

@section('title', 'Feedback form')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Feedback form</h3>
                </div>
                <form role="form" method="POST" action="{{url('/fb')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('theme') ? ' has-error' : '' }}">
                            <label for="theme">Theme message:</label>
                            <input type="text" class="form-control" value="{{old('theme')}}" id="theme" name="theme" placeholder="The theme text">
                            @if ($errors->has('theme'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('theme') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('message') ? ' has-error' : '' }}">
                            <label for="message">Message:</label>
                            <textarea class="form-control" rows="5" name="message" id="message" placeholder="Enter message text">{{old('message')}}</textarea>
                            @if ($errors->has('message'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('message') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('file') ? ' has-error' : '' }}">
                            <label for="file">File:</label>
                            <input type="file" id="file" name="file" value="{{old('file')}}">
                            @if ($errors->has('file'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('file') }}</strong>
                                </span>
                            @endif
                            <p class="help-block">Any file what you need to attach</p>
                        </div>
                    </div>

                    <div class="box-footer">
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop