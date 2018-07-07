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
                            <h4 class="title">Hasil Pelatihan Dan Pengujian {{str_replace('_',' ',$tipe)}}</h4>
                        </div>
                        <div class="card-content table-responsive">
                            <div class="card-body">

                                <table class="table table-responsive table-hover table-bordered">
                                    <thead class="bg-info">
                                    <th>
                                        Total Data
                                    </th>
                                    <th>
                                        Total Data Latih
                                    </th>
                                    <th>
                                        Total Data Uji
                                    </th>
                                    <th>
                                        Alfa
                                    </th>
                                    <th>
                                        Window
                                    </th>
                                    <th>
                                        Kfold
                                    </th>
                                    <th>
                                        Epoch
                                    </th>
                                    <th>
                                        Pengujian Terbaik
                                    </th>
                                    <th>
                                        Akurasi Terbaik
                                    </th>
                                    <th>
                                        Akurasi Rata-Rata
                                    </th>
                                    <th>
                                        Vektor 1
                                    </th>
                                    <th>
                                        Vektor 2
                                    </th>
                                    <th>
                                        Aksi
                                    </th>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $Data )
                                        <tr class="{{ $idRujukan == $Data->id ? 'bg-info': '' }}">
                                            <td>
                                                {{$Data->totalData}}
                                            </td>
                                            <td>
                                                {{$Data->totalDataLatih}}
                                            </td>
                                            <td>
                                                {{$Data->totalDataUji}}
                                            </td>
                                            <td>
                                                {{$Data->alfa}}
                                            </td>
                                            <td>
                                                {{$Data->window}}
                                            </td>
                                            <td>
                                                {{$Data->kfold}}
                                            </td>
                                            <td>
                                                {{$Data->epoch}}
                                            </td>
                                            <td>
                                                k-Fold ke {{$Data->pengujianTerbaik}}
                                            </td>
                                            <td>
                                                {{$Data->akurasiTerbaik}} %
                                            </td>
                                            <td>
                                                {{$Data->akurasiRataRata}} %
                                            </td>
                                            <td>
                                                {{$Data->vektor1}}
                                            </td>
                                            <td>
                                                {{$Data->vektor2}}
                                            </td>
                                            <td class="td-name">
                                                <a type="button" rel="tooltip" class="btn btn-primary"
                                                   href="{{url('hasil/'.$tipe.'/'.$Data->id)}}">
                                                    {{--  <i class="material-icons">refresh</i>--}}
                                                    Lihat Rincian
                                                </a>
                                                @if($idRujukan ==$Data->id)
                                                    <a type="button" rel="tooltip" class="btn btn-warning"
                                                       href="{{url('setLatih/'.$Data->jnsQolqolah.'/'.$Data->id)}}">
                                                        {{--  <i class="material-icons">refresh</i>--}}
                                                        Digunakan Sebagai Vektor Uji
                                                    </a>
                                                @else
                                                    <a type="button" rel="tooltip" class="btn btn-success"
                                                       href="{{url('setLatih/'.$Data->jnsQolqolah.'/'.$Data->id)}}">
                                                        {{--  <i class="material-icons">refresh</i>--}}
                                                        Set Sebagai Vektor Uji
                                                    </a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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