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
                            <h4 class="title">Hasil Pelatihan Dan Pengujian</h4>
                        </div>
                        <div class="card-content table-responsive">
                            <div class="card-body">

                                <table class="table table-responsive table-hover">
                                    <thead>
                                    <th>
                                        Jenis Qolqolah
                                    </th>
                                    <th>
                                        Jumlah Hasil Pengujian
                                    </th>
                                    <th>
                                    </th>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $Data )
                                        <tr>
                                            <td>
                                                {{str_replace('_',' ',$Data->nama)}}
                                            </td>
                                            <td>
                                                {{count(\App\Hasils::where('jnsQolqolah',$Data->nama)->get())}}
                                            </td>
                                            <td class="td-actions">
                                                <a type="button" rel="tooltip" class="btn btn-success"
                                                   href="hasil/{{$Data->nama}}">
                                                    {{--  <i class="material-icons">refresh</i>--}}
                                                    Lihat
                                                </a>

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