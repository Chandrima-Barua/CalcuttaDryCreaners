@extends('layouts.auth')
@section('navcontent')
<div class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 mx-auto">
            <div class="card shadow">
                <div class="card-header text-center"><strong>Expense Details</strong></div>

                <div class="card-body">
                    @include('includes.messages')
                    <form>
                        <div class="form-group row">
                            <label for="expense_category" class="col-sm-2 col-form-label">Expense Category*</label>
                            <div class="col-md-6">
                                <input id="expense_category" name="expense_category" class="form-control" readonly
                                    value="{{ $expense_category->name }}">

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="branch" class="col-sm-2 col-form-label">Branch*</label>
                            <div class="col-md-6">
                                <input id="branch" name="name" class="form-control" readonly
                                    value="{{ $branch->name }}">

                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">{{ __('Entry date*') }}</label>

                            <div class="col-md-6">
                                <input id="entry_date" name="name" class="form-control" readonly
                                    value="{{ $expense->entry_date }}">

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">{{ __('Amount*') }}</label>

                            <div class="col-md-6">
                                <input id="amount" name="amount" class="form-control" readonly
                                    value="{{ $expense->amount }}">

                            </div>
                        </div>
                        <div class="form-group">
                            <a class="btn btn-success" href="{{ route('expense.index') }}">Go back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('jscript')

<script type="text/javascript">
$(document).ready(function() {
    n = new Date();
    y = n.getFullYear();
    m = n.getMonth() + 1;
    d = n.getDate();
    $("#entry_date").val(d + "/" + m + "/" + y);

});
</script>
@endsection