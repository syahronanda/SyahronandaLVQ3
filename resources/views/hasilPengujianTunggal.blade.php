{{--
/**
 * Created by PhpStorm.
 * User: syahronanda
 * Date: 08/05/18
 * Time: 14:23
 */--}}

@extends('layouts.app')

@section('title','TA BOBBY MAU WISUDA')

@push('css')

@endpush

@section('content')
    <div class="content" id="app">
        <example-component></example-component>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('layouts.partial.msg')
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">Status Pengujian Suara {{str_replace('_',' ',$tipe)}}</h4>
                        </div>
                        <div class="card-content table-responsive">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Data Input</label>
                                            {{$DataView['DataUji']}}
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Data Vektor Suara Benar</label>
                                            {{$DataView['DataV1']}}
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Data Vektor Suara Salah</label>
                                            {{$DataView['DataV2']}}
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Perbandingan Kedekatan Vektor</label>
                                            Kedekatan Ke Vektor Suara Benar = {{$DataView['V1']}}<br>
                                            Kedekatan Ke Vektor Suara Salah = {{$DataView['V2']}}
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row" data-background-color="{{ $DataView['Hasil'] == 1 ? 'green': 'red' }}">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            Status Suara :
                                            @if($DataView['Hasil'] == 1)
                                                Benar
                                            @else
                                                Salah
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <center>

                                    <a href="{{url('uji/'.$tipe)}}" class="btn btn-primary">Coba Lagi</a>
                                </center>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

@push('scripts')

@endpush