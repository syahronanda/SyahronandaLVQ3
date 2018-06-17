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
                            <h4 class="title">Data</h4>
                        </div>
                        <div class="card-content table-responsive">
                            <div class="card-body">
                                <div>
                                    <button class="btn btn-success btn-raised btn-round" data-toggle="modal"
                                            data-target="#addModal">
                                        <i class="material-icons" style="font-size: 10px">add_circle</i>Tambah Data
                                    </button>
                                </div>
                                <table class="table table-responsive table-hover">
                                    <thead>
                                    <th>
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
                                            <td class="td-actions">
                                                <button type="button" rel="tooltip" class="btn btn-success">
                                                  {{--  <i class="material-icons">refresh</i>--}}
                                                    edit
                                                </button>
                                                <button type="button" rel="tooltip" class="btn btn-danger">
                                                   {{-- <i class="material-icons">close</i>--}}
                                                    hapus
                                                </button>
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

    <!-- Classic Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="AddModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons">clear</i>
                    </button>
                    <h4 class="modal-title">Tambah Data</h4>
                </div>
                <div class="modal-body">

                    <div class="card-content">
                        <form method="POST" action="{{ route('data.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row text-center">
                                <div class="col-md-12">
                                    <i class="material-icons" style="font-size: 96px">insert_drive_file</i>
                                    <p>
                                        Data yang akan diinputkan harus berformat <b>*txt</b>
                                    </p>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Jenis Data Qolqolah</label>
                                        <select class="form-control" name="nama">
                                            <option value="ba_sughro">Ba Sughro</option>
                                            <option value="ba_wustho">Ba Wustho</option>
                                            <option value="ba_kubro">Ba Kubro</option>
                                            <option value="jim_sughro">Jim Sughro</option>
                                            <option value="jim_wustho">Jim Wustho</option>
                                            <option value="jim_kubro">Jim Kubro</option>
                                            <option value="dal_sughro">Dal Sughro</option>
                                            <option value="dal_wustho">Dal Wustho</option>
                                            <option value="dal_kubro">Dal Kubro</option>
                                            <option value="tho_sughro">Tho Sughro</option>
                                            <option value="tho_wustho">Tho Wustho</option>
                                            <option value="tho_kubro">Tho Kubro</option>
                                            <option value="qof_sughro">Qof Sughro</option>
                                            <option value="qof_wustho">Qof Wustho</option>
                                            <option value="qof_kubro">Qof Kubro</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <center>
                                <div class="row">
                                    <div class="col-md-12">

                                        <label class="control-label"></label>
                                        <input type="file" name="file" id="input-b9">

                                        <div id="kartik-file-errors"></div>
                                    </div>
                                </div>
                            </center>


                            <div class="modal-footer text-center">
                                <button type="submit" class="btn btn-info">Simpan</button>
                                <button type="reset" class="btn btn-success">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!--  End Modal -->


@endsection

@push('scripts')

@endpush