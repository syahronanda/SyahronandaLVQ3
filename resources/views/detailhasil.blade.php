@extends('layouts.app')

@section('title','TA BOBBY MAU WISUDA')
{{--<link rel="stylesheet" type="text/css" href="https://adminlte.io/themes/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"/>--}}
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
                            <h4 class="title">Data Normalisasi</h4>
                        </div>
                        <div class="card-content table-responsive">
                            <div class="row">
                            {{\App\Http\Controllers\ProsesController::tes($alfa,$window,$kfold)}}
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