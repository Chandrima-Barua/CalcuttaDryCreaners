@extends('layouts.auth')
@section('navcontent')
    <div class="container-fluid my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 mx-auto">
                <div class="card shadow">
                    <div class="card-header text-center"><strong>Order Statuses</strong></div>

                    <div class="card-body">
                        @include('includes.messages')
                        @if(count($orderstatuses) > 0)
                        @foreach($orderstatuses as $orderstatus)
                            @if(!$loop->last)
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5>{{ $orderstatus->title }}</h5>
                                    </div>
                                    <div>
                                        <a href="{{ route('orderstatus.makedefault', $orderstatus->id) }}"><i class="{{ $orderstatus->isDefault ? 'fas' : 'far' }} fa-2x fa-star text-primary"></i></a>
                                        <a href="{{ route('orderstatus.edit', $orderstatus->id) }}"><i class="fas fa-2x fa-edit text-primary"></i></a>
                                        <a href="{{ route('orderstatus.destroy', $orderstatus->id) }}"><i class="fas fa-2x fa-trash text-danger"></i></a>
                                    </div>
                                </div>
                                <hr>
                            @else
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5>{{ $orderstatus->title }}</h5>
                                    </div>
                                    <div>
                                        <a href="{{ route('orderstatus.makedefault', $orderstatus->id) }}"><i class="{{ $orderstatus->isDefault ? 'fas' : 'far' }} fas fa-star text-primary"></i></a>&nbsp;&nbsp;
                                        <a href="{{ route('orderstatus.edit', $orderstatus->id) }}"><i class="fas text-warning fa-edit">></i></a>&nbsp;&nbsp;
                                        <a href="{{ route('orderstatus.destroy', $orderstatus->id) }}"><i class="fas text-danger fa-trash"></i></a>&nbsp;
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @else
                            <p class="text-center">No order statuses found!</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
