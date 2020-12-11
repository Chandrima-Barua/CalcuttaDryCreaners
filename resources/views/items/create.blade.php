@extends('layouts.auth')
@section('navcontent')
<div class="container">
    <form method="POST" action="{{ route('items.store') }}">
        @csrf
        <fieldset>
            <legend>{{ __('Create New Item') }}</legend>
            <!-- @include('includes.messages') -->

            @if ($errors->any())
          <div class="alert alert-danger">
                    <ul>
                    @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                @endforeach
             </ul>
             </div>
             @endif
        <!--error ends-->
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="name">Item Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="col">
                        <label for="code">Item Code</label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" required>
                    </div>
                    <div class="col">
                    <label for="exampleFormControlSelect1">Select Type</label>
                    <select class="form-control types" name="itemTypeid" id="types">
                        <option value='0'>-- Select Type --</option>
                        @foreach($itemstypes as $itemstype)
                        <option value='{{ $itemstype->id }}'>{{ $itemstype->name }}</option>
                        @endforeach
                    </select>
                    <input type='hidden' name='allitemstypes' class='allitemstypes'>
                </div>
                </div>
            </div>
            
            <div class="form-group">
                <legend>{{ __('Select Service') }}</legend>
                <table class="table table-responsive">
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
                            <td><label><input type="checkbox" name="services[]" id="services"
                            value="{{$service->id}}" /> {{ $service->name }}</label></td>
                            <td><input type="text" class="form-control" id="regularPrice" name="regularPrice[]"></td>
                            <td><input type="text" class="form-control" id="urgentPrice" name="urgentPrice[]"></td>
                            <td><input type="text" class="form-control" id="regularDeliveryTime"
                                    name="regularDeliveryTime[]"></td>
                            <td><input type="text" class="form-control" id="urgentDeliveryTime"
                                    name="urgentDeliveryTime[]"></td>
                                    <td>
                            <select name="discount[]" id="discount">
                                <option selected disabled>Select</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br><br>
            </div>

            <br><br>
            <div class="form-group">
                <label for="itemNote">Note to customer (e.g: Don't put fabrics that disburses color)</label>
                <textarea class="form-control" name="itemNote" id="mytextarea">
                                    {{ old('itemNote') }}
                                </textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
    </form>

</div>
@endsection