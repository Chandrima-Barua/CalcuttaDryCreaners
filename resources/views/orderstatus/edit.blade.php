@extends('layouts.auth')
@section('navcontent')
    <div class="container-fluid my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 mx-auto">
                <div class="card shadow">
                    <div class="card-header text-center"><strong>Edit Order Status</strong></div>

                    <div class="card-body">
                        @include('includes.errors')
                        <form method="POST" action="{{ route('orderstatus.update', $orderstatus->id) }}">
                            @csrf
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input class="form-control" id="title" name="title" value="{{ $orderstatus->title }}">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
