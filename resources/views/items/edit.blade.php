@extends('layouts.auth')
@section('navcontent')
<div class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 mx-auto">
            <div class="card shadow">
                <div class="card-header text-center"><strong>Edit Item</strong></div>

                <div class="card-body">
                    @include('includes.messages')
                    <form method="POST" action="{{ route('items.update', $item->id) }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="name">Item Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $item->name }}">
                                </div>
                                <div class="col">
                                    <label for="code">Item Code</label>
                                    <input type="text" class="form-control" id="code" name="code"
                                        value="{{ $item->code }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-xs-4">
                                <label for="exampleFormControlSelect1">Select Type</label>
                                <select class="form-control types" name="itemTypeid" id="types">
                                    @foreach($itemstypes as $itemstype)
                                    <option readonly value='{{ $itemstype->id }}'>{{ $itemstype->name }}</option>
                                    @endforeach
                                </select>
                                <input type='hidden' name='allitemstypes' class='allitemstypes'>
                            </div>
                        </div>

                        <div class="form-group">
                            <legend>{{ __('Select Service') }}</legend>
                            <table class="table">
                                <thead>

                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Services</th>
                                        <th scope="col">Regular Price</th>
                                        <th scope="col">Urgent Price</th>
                                        <th scope="col">Regular Delivery Time (Day/s)</th>
                                        <th scope="col">Urgent Delivery Time (Day/s)</th>
                                        <th scope="col">Discount</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach($services as $service)
                                    <tr>
                                        <td scope="row">{{ $service->id }}</td>
                                        <td><label>
                                                <input type="checkbox" name="services[]" id="services"
                                                    value="{{$service->id}}"
                                                    {{$service->id == $item->service_id ? 'checked' : ''}} />
                                                {{$service->name}}
                                            </label>

                                        </td>
                                        <td><input type="text" class="form-control" id="regularPrice"
                                                name="regularPrice[]" value="{{ $item->regularPrice }}"></td>
                                        <td><input type="text" class="form-control" id="urgentPrice"
                                                name="urgentPrice[]" value="{{ $item->urgentPrice }}"></td>
                                        <td><input type="text" class="form-control" id="regularDeliveryTime"
                                                name="regularDeliveryTime[]" value="{{ $item->regularDeliveryTime }}">
                                        </td>
                                        <td><input type="text" class="form-control" id="urgentDeliveryTime"
                                                name="urgentDeliveryTime[]" value="{{ $item->urgentDeliveryTime }}">
                                        </td>
                                        <td>
                                            <select name="discount[]" id="discount">
                                               
                                                @if ($service->id == $item->service_id)

                                               
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                                @else
                                                <option selected disabled>Select</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                                @endif
                                            </select>

                                            <!-- <select name="discount[]" id="discount">
                                                <option value="{{ $item->discount }}">@if ($item->discount == 1) Yes
                                                    @else No @endif</option> -->
                                            <!-- </select> -->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <br><br>
                        </div>

                        <!-- <div class="form-group row">
                            <div class="col-xs-2">
                                <label for="tax">Tax %</label>
                                <input type="text" class="form-control" id="tax" name="tax" size="10"
                                    value="{{ $item->tax }}">
                            </div>
                            <div class="col-xs-2">
                                <label for="discount">Discount</label>
                                <input type="text" class="form-control" id="discount" name="discount"
                                    value="{{ $item->discount }}">
                            </div>
                            <select name="discountType" id="discountType">
                                <option value="{{ $item->discountType }}">{{ $item->discountType }}
                                </option>
                            </select>
                        </div> -->

                        <br><br>
                        <div class="form-group">
                            <label for="itemNote">Note to customer (e.g: Don't put fabrics that disburses color)</label>
                            <textarea class="form-control" name="itemNote" id="mytextarea">
                            {{ $item->itemNote }}
                                </textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{route('items.index')}}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection