@extends('layouts.auth')
@section('navcontent')
<div class="container">
    <form method="POST" action="{{ route('legal_documents.store') }}">
        @csrf
        <fieldset>
            <legend>{{ __('Create New Documents') }}</legend>
            @include('includes.messages')

            <div class="form-group">
                <div class="row">
                    <label for="legalcategory">Legal Category</label>
                    <div class="col-sm-4">

                        <select class="form-control legalcategory" name="legalcategory" id="legalcategory"
                            aria-labelledby='legalcategory' required>
                            @foreach($legal_categories as $legal_category)
                            <option value='{{ $legal_category->id }}'>{{ $legal_category->name }}</option>
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
                            aria-labelledby='lblRange' value='' />
                    </div>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="bike_ending" name="bike_ending"
                            aria-labelledby='lblRange' value='' />
                    </div>
                </div>
            </div>

            <div class="form-group">

                <div class="row">

                    <label id='lblRange'>Insurance</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="insurance_starting" name="insurance_starting"
                            aria-labelledby='lblRange' required />
                    </div>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="insurance_ending" name="insurance_ending"
                            aria-labelledby='lblRange' required />
                    </div>
                </div>
            </div>
            <div class="form-group">

                <div class="row">

                    <label id='lblRange'>Tax Token</label>
                    <div class="col-sm-4 set">
                        <input type="date" class="form-control" id="taxtoken_starting" name="taxtoken_starting"
                            aria-labelledby='lblRange' required />
                    </div>
                    <div class="col-sm-4 set">
                        <input type="date" class="form-control" id="taxtoken_ending" name="taxtoken_ending"
                            aria-labelledby='lblRange' required />
                    </div>
                </div>
            </div>
            <div class="form-group">

                <div class="row">

                    <label id='lblRange'>Fitness</label>
                    <div class="col-sm-4 set">
                        <input type="date" class="form-control" id="fitness_starting" name="fitness_starting"
                            aria-labelledby='lblRange' value='' />
                    </div>
                    <div class="col-sm-4 set">
                        <input type="date" class="form-control" id="fitness_ending" name="fitness_ending"
                            aria-labelledby='lblRange' value='' />
                    </div>
                </div>
            </div>
            <div class="form-group ">
                <!-- <div class="col-md-6 offset-md-2"> -->
                <button type="submit" class="btn btn-primary">
                    {{ __('Create') }}
                </button>
                <!-- </div> -->
            </div>

        </fieldset>

    </form>
</div>
@endsection

