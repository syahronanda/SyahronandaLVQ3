@extends('layouts.app')

@section('title','Proses')

@push('css')

@endpush

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('layouts.partial.msg')
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">Pengujian Data Tunggal Qolqolah {{$tipe}}</h4>
                        </div>
                        <div class="card-content">
                            <form method="POST" action="{{route('uji.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Hasil Ekstrasi Ciri Suara</label>
                                            {{--<textarea class="form-control" name="ciri"></textarea>--}}
                                            <input type="text" class="form-control" name="ciri"></input>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="tipe" value="{{$tipe}}">

                                <center>

                                    <button type="submit" class="btn btn-primary">Proses</button>
                                    <button type="reset" class="btn btn-success">Reset</button>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush