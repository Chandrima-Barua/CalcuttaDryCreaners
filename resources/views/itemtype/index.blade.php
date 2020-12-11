@extends('layouts.auth')
@section('navcontent')
<div class="container">
    <div class="row justify-content-center">
            <div class="card shadow">
                    <div class="card-header text-center"><strong>Item Types</strong></div>

                    <div class="card-body">
                        @include('includes.messages')
                        @if(count($itemtypes) > 0)
                            <table class="table table-hover table-responsive">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($itemtypes as $itemtype)
                                        <tr>
                                            <td>{{ $itemtype->id }}</td>
                                            <td>{{ $itemtype->name }}</td>
                                           
                                            <td>
                                                <div class="d-flex align-items-center justify-content-around">
                                                    <a href="{{ route('itemtype.edit', $itemtype->id) }}"><i class="fas text-warning fa-edit"></i></a>&nbsp;&nbsp;
                                                    <a href="{{ route('itemtype.destroy', $itemtype->id) }}"><i class="fas text-danger fa-trash"></i></a>&nbsp;
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center">No services found!</p>
                        @endif
                    </div>
            </div>
        </div>
    </div>
@endsection
