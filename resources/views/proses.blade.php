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
                            <h4 class="title">Pelatihan Dan Pengujian LVQ 3</h4>
                        </div>
                        <div class="card-content">
                            <form method="POST" action="{{route('proses.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Jenis Data Qolqolah </label>
                                            <select class="form-control" name="namafile">
                                                @if (file_exists('upload/ba_sughro.txt'))
                                                    <option value="ba_sughro">Ba Sughro</option>
                                                @endif

                                                @if (file_exists('upload/ba_wustho.txt'))
                                                    <option value="ba_wustho">Ba Wustho</option>
                                                @endif
                                                @if (file_exists('upload/ba_kubro.txt'))
                                                    <option value="ba_kubro">Ba Kubro</option>
                                                @endif
                                                @if (file_exists('upload/jim_sughro.txt'))
                                                    <option value="jim_sughro">Jim Sughro</option>
                                                @endif
                                                @if (file_exists('upload/jim_wustho.txt'))
                                                    <option value="jim_wustho">Jim Wustho</option>
                                                @endif
                                                @if (file_exists('upload/jim_kubro.txt'))
                                                    <option value="jim_kubro">Jim Kubro</option>
                                                @endif
                                                @if (file_exists('upload/dal_sughro.txt'))
                                                    <option value="dal_sughro">Dal Sughro</option>
                                                @endif
                                                @if (file_exists('upload/dal_wustho.txt'))
                                                    <option value="dal_wustho">Dal Wustho</option>
                                                @endif
                                                @if (file_exists('upload/dal_kubro.txt'))
                                                    <option value="dal_kubro">Dal Kubro</option>
                                                @endif
                                                @if (file_exists('upload/tho_sughro.txt'))
                                                    <option value="tho_sughro">Tho Sughro</option>
                                                @endif
                                                @if (file_exists('upload/tho_wustho.txt'))
                                                    <option value="tho_wustho">Tho Wustho</option>
                                                @endif
                                                @if (file_exists('upload/tho_kubro.txt'))
                                                    <option value="tho_kubro">Tho Kubro</option>' : ''}}
                                                @endif
                                                @if (file_exists('upload/qof_sughro.txt'))
                                                    <option value="qof_sughro">Qof Sughro</option>' : ''}}
                                                @endif
                                                @if (file_exists('upload/qof_wustho.txt'))
                                                    <option value="qof_wustho">Qof Wustho</option>' : ''}}
                                                @endif
                                                @if (file_exists('upload/qof_kubro.txt'))
                                                    <option value="qof_kubro">Qof Kubro</option>' : ''}}
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nilai Alfa (a)</label>
                                            <select class="form-control" name="alfa">

                                                <option value="0.025">0.025</option>
                                                <option value="0.05">0.05</option>
                                                <option value="0.075">0.075</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nilai Window (e)</label>
                                            <select class="form-control" name="window">

                                                <option value="0.2">0.2</option>
                                                <option value="0.3">0.3</option>
                                                <option value="0.4">0.4</option>
                                                <option value="0.5">0.5</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nilai K (K-fold)</label>
                                            <select class="form-control" name="kfold">

                                                <option value="5">5-fold</option>
                                                <option value="10">10-fold</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>

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