@extends('layouts.app')

@section('title','TA BOBBY MAU WISUDA')

@push('css')

@endpush

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="green">
                            <h4 class="title">Title</h4>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <strong>Name: Fulan</strong><br>
                                    <b>Email: bob</b> <br>
                                    <strong>Message: </strong><hr>

                                    <p>ini pesan</p><hr>

                                </div>
                            </div>
                            <button class="btn btn-success btn-raised btn-round" data-toggle="modal" data-target="#myModal">
                                Classic modal
                            </button>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Classic Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons">clear</i>
                    </button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">

                    <div class="card-content">
                        <form method="POST" {{--action="{{ route('item.store') }}"--}} enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Name</label>
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Description</label>
                                        <textarea class="form-control" name="description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Price</label>
                                        <input type="number" class="form-control" name="price">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label">Image</label>
                                    <input type="file" name="image">
                                </div>
                            </div>
                            <a href="#" class="btn btn-danger">Back</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-simple">Nice Button</button>
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--  End Modal -->
@endsection

@push('scripts')

@endpush