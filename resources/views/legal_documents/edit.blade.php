@extends('layouts.auth')
@section('navcontent')
<div class="container">
    <form method="POST" action="{{ route('legal_documents.update', $legal_document->id) }}">
        @csrf
        <fieldset>
            <legend>{{ __('Edit Document') }}</legend>
            @include('includes.messages')

            <div class="form-group">
                <div class="row">
                    <label for="legalcategory">Legal Category</label>
                    <div class="col-sm-4">

                        <select class="form-control legalcategory" name="legalcategory" id="legalcategory"
                            aria-labelledby='legalcategory'>
                            @foreach($legal_categories as $legal_category)
                            <option value='{{ $legal_category->id }}' @if ($legal_category->id ==
                                $legal_document->legal_categories_id )
                                selected
                                @endif >{{$legal_category->name}}</option>
                            @endforeach

                        </select>

                    </div>
                </div>
            </div>


            <div class="form-group">

                <div class="row">

                    <label id='lblRange'>Number Input</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="bike_starting" name="bike_starting"
                            aria-labelledby='lblRange' value="{{$legal_document->bike_starting}}" />
                    </div>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="bike_ending" name="bike_ending"
                            aria-labelledby='lblRange' value="{{$legal_document->bike_ending}}" />
                    </div>
                </div>
            </div>

            <div class="form-group">

                <div class="row">

                    <label id='lblRange'>Insurance</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="insurance_starting" name="insurance_starting"
                            aria-labelledby='lblRange' value="{{$legal_document->insurance_starting}}" />
                    </div>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="insurance_ending" name="insurance_ending"
                            aria-labelledby='lblRange' value="{{$legal_document->insurance_ending}}" />
                    </div>
                </div>
            </div>
            <div class="form-group">

                <div class="row">

                    <label id='lblRange'>Tax Token</label>
                    <div class="col-sm-4 set">
                        <input type="date" class="form-control" id="taxtoken_starting" name="taxtoken_starting"
                            aria-labelledby='lblRange' value="{{$legal_document->taxtoken_starting}}" />
                    </div>
                    <div class="col-sm-4 set">
                        <input type="date" class="form-control" id="taxtoken_ending" name="taxtoken_ending"
                            aria-labelledby='lblRange' value="{{$legal_document->taxtoken_ending}}" />
                    </div>
                </div>
            </div>
            <div class="form-group">

                <div class="row">

                    <label id='lblRange'>Fitness</label>
                    <div class="col-sm-4 set">
                        <input type="date" class="form-control" id="fitness_starting" name="fitness_starting"
                            aria-labelledby='lblRange' value="{{$legal_document->fitness_starting}}" />
                    </div>
                    <div class="col-sm-4 set">
                        <input type="date" class="form-control" id="fitness_ending" name="fitness_ending"
                            aria-labelledby='lblRange' value="{{$legal_document->fitness_ending}}" />
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>

        </fieldset>
    </form>
</div>
@endsection