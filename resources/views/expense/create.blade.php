@extends('layouts.auth')
@section('navcontent')
<div class="container">
    <form method="POST" action="{{ route('expense.store') }}">
        @csrf
        <fieldset>
            <legend>{{ __('Create New Expense') }}</legend>
            @include('includes.messages')
            <div class="form-group row">
                <label for="expense_category" class="col-sm-2 col-form-label">Expense Category*</label>
                <div class="col-md-6">
                    <select class="form-control expense_category" name="expense_category" id="expense_category">
                        @foreach($expense_categories as $expense_category)
                        <option value='{{ $expense_category->id }}'>{{ $expense_category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="branch" class="col-sm-2 col-form-label">Branch*</label>
                <div class="col-md-6">
                    <select class="form-control branch" name="branch" id="branch">
                        @foreach($branches as $branch)
                        <option value='{{ $branch->id }}'>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">{{ __('Entry date*') }}</label>

                <div class="col-md-6">
                    <input id="entry_date" type="date" class="form-control @error('entry_date') is-invalid @enderror"
                        name="name" value="{{ old('entry_date') }}" required autocomplete="entry_date" autofocus
                        placeholder="Enter entry date">

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">{{ __('Amount*') }}</label>

                <div class="col-md-6">
                    <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror"
                        name="amount" value="{{ old('amount') }}" required autocomplete="amount" autofocus
                        placeholder="Enter amount">

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row ">
                <div class="col-md-6 offset-md-2">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Create') }}
                    </button>
                </div>
            </div>

        </fieldset>

    </form>
</div>
@endsection