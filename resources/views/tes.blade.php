@extends('layouts.app')

@section('title','TA BOBBY MAU WISUDA')
{{--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>--}}
@push('css')

@endpush

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('layouts.partial.msg')
                    <div class="card">
                        <div class="card-header" data-background-color="green">
                            <h4 class="title">Data Normalisasi</h4>
                        </div>
                        <div class="card-content table-responsive">
                            @if (!file_exists('upload/FileEkstrasi.txt'))
                            <button class="btn btn-success btn-raised btn-round" data-toggle="modal" data-target="#addModal">
                                <i class="material-icons" style="font-size: 24px">add_circle</i>Tambah Data
                            </button>
                            @else
                            <button class="btn btn-danger btn-raised btn-round" data-toggle="modal" data-target="#delModal">
                                <i class="material-icons" style="font-size: 24px">clear</i>Hapus Data
                            </button>
                            @endif
                            <div class="clearfix"></div>

                            @if (file_exists('upload/FileEkstrasi.txt'))
                            <div class="table-responsive material-datatables">
                                <table class="table table-bordered" style="width: 100%" id="datatables">
                                    {{--<thead class="text-primary">
                                    @for($i=1;$i <=20;$i++)
                                    <th>CIRI {{$i}}</th>
                                    @endfor

                                    <th>STATUS</th>
                                    </thead>
                                    <tbody>
                                    @for($i=1;$i <=50;$i++)
                                    <tr>
                                        @for($j=1;$j <=20;$j++)
                                            <td>{{rand(-1,1)}}.{{rand(1,1000)}}</td>
                                        @endfor
                                        <td class="text-primary">B</td>
                                    </tr>
                                    @endfor
                                    </tbody>--}}
                                    {{addTable($info,$jumlahdata)}}
                                </table>
                            </div>
                                @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Classic Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="AddModalLabel" aria-hidden="true">
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
                                        Data yang akan diinputkan harus berformat <b>*txt</b> atau <b>*csv</b>
                                    </p>
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


                    </div>

                </div>
                <div class="modal-footer text-center">
                    <button type="submit" class="btn btn-info">Simpan</button>
                    <button type="reset" class="btn btn-success">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--  End Modal -->

    <!-- Classic Modal -->
    <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="DelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons">clear</i>
                    </button>
                    <h4 class="modal-title">Hapus Data</h4>
                </div>
                <div class="modal-body">

                    <div class="card-content">
                                                    <div class="row text-center">
                                <div class="col-md-12">
                                    <i class="material-icons" style="font-size: 96px">warning</i>
                                    <h4>
                                        Apakah anda yakin akan menghapus semua data latih ?
                                    </h4>
                                </div>
                            </div>



                    </div>

                </div>
                <div class="modal-footer text-center">
                    <a href="{{ url('hapus') }}" class="btn btn-warning">Hapus</a>
                    <button  class="btn btn-info" data-dismiss="modal">Batalkan</button>
                </div>
            </div>
        </div>
    </div>
    <!--  End Modal -->

@endsection

@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }

        });


        var table = $('#datatables').DataTable();

        // Edit record
        table.on('click', '.edit', function() {
            $tr = $(this).closest('tr');

            var data = table.row($tr).data();
            alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
        });

        // Delete a record
        table.on('click', '.remove', function(e) {
            $tr = $(this).closest('tr');
            table.row($tr).remove().draw();
            e.preventDefault();
        });

        //Like record
        table.on('click', '.like', function() {
            alert('You clicked on Like button');
        });

        $('.card .material-datatables label').addClass('form-group');
    });
</script>
@endpush