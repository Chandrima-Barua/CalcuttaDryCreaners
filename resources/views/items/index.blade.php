@extends('layouts.auth')
@section('navcontent')
<div class="container">
    <div class="row justify-content-center">
            <div class="card shadow">
                <div class="card-header text-center"><strong>Items</strong></div>

                <div class="card-body">
                    @include('includes.messages')
                    @if(count($items) > 0)
                    <table class="table table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item Name</th>
                                <th>Item Code</th>
                                <th>Service Name</th>
                                <th>Regular Price</th>
                                <th>Urgent Price</th>
                                <th>Regular Delivery Time</th>
                                <th>Urgent Delivery Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $i = 1;
                        ?>
                            @foreach($items as $item)
                            <tr>
                                <td id="{{ $item->id }}">{{ $i++ }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->code }}</td>
                                <td>


                                    @if(!$loop->last)
                                    {{$item->service_name }}&nbsp;
                                    @else
                                    {{$item->service_name }}
                                    @endif

                                </td>
                                <td>{{ $item->regularPrice }}/- BDT</td>
                                <td>{{ $item->urgentPrice }}/- BDT</td>
                                <td>{{ $item->regularDeliveryTime }} day(s)</td>
                                <td>{{ $item->urgentDeliveryTime }} day(s)</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-around">
                                        <a href="{{ route('items.show', $item->id) }}"><i
                                                class="fas text-primary fa-eye"></i></a>&nbsp;&nbsp;
                                        <a href="{{ route('items.edit', $item->id) }}"><i
                                                class="fas text-warning fa-edit"></i></a>&nbsp;&nbsp;
                                        <a href="{{ route('items.destroy', $item->id) }}"><i
                                                class="fas text-danger fa-trash"></i></a>&nbsp;

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