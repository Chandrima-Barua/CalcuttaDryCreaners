@extends('layouts.auth')
@section('navcontent')

<h3 class="page-title">Staff Expense Report</h3>

<form action="{{route('staffexpense.search')}}" method="get" class="form-inline">

    <div class="form-group row">
        <div class="col-sm-2 col-form-label">
            {!! Form::label('year','Year') !!}
            {!! Form::select('y', array_combine(range(date("Y"), 1900), range(date("Y"), 1900)), old('y',
            Request::get('y',
            date('Y'))), ['class' => 'form-control']) !!}
        </div>
        <div class="col-sm-2 col-form-label">
            {!! Form::label('month','Month') !!}
            {!! Form::select('m', cal_info(0)['months'], old('m', Request::get('m', date('m'))), ['class' =>
            'form-control']) !!}
        </div>
        <div class="col-sm-2 col-form-label">
            {!! Form::label('day','Day') !!}
            {{ Form::selectRange('day', 0, 31, null, array('class' => 'form-control')) }}
        </div>
        <div class="col-xs-4">
            <label class="control-label">&nbsp;</label><br>
            {!! Form::submit('Search',['class' => 'btn btn-success']) !!}
        </div>


    </div>
</form>
<br><br><br>
<div class="panel panel-default">

    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Income</th>
                        <th> {{$inc_total}} /-</th>

                    </tr>
                    <tr>
                        <th>Staff Expenses</th>
                        <th> {{$exp_total}} /-</th>
                    </tr>
                    @if ($profit > $inc_total)
                    <tr>
                        <th>Profit</th>
                        <th> {{$profit}} /-</th>
                    </tr>
                    @endif
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th colspan="2">Income by Branch</th>

                    </tr>
                    @foreach($inc_summary as $inc)
                    <tr>
                        <th>{{ $inc['name'] }}</th>
                        <th>{{ $inc['amount'] }} /-</th>

                    </tr>
                    @endforeach
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th colspan="2">Expenses by category</th>

                    </tr>
                    @foreach($exp_summary as $inc)
                    <tr>
                        <th>{{ $inc['name'] }}</th>
                        <th>{{ $inc['amount'] }} /-</th>

                    </tr>
                    @endforeach
                </table>
            </div>
           
        </div>
       
    </div>
</div>
<br><br><br>
<div class="panel panel-default">
<h5>Yearly Report</h5>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Yearly Income</th>
                        <th> {{$income}} /-</th>

                    </tr>
                    <tr>
                        <th>Yearly Staff Expenses</th>
                        <th> {{$expense}} /-</th>
                    </tr>
                   
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th colspan="2">Yearly Income by Branch</th>

                    </tr>
                    @foreach($inc_summary as $inc)
                    <tr>
                        <th>{{ $inc['name'] }}</th>
                        <th>{{ $inc['amount'] }} /-</th>

                    </tr>
                    @endforeach
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th colspan="2">Yearly Expenses by Category</th>

                    </tr>
                    @foreach($exp_summary as $inc)
                    <tr>
                        <th>{{ $inc['name'] }}</th>
                        <th>{{ $inc['amount'] }} /-</th>

                    </tr>
                    @endforeach
                </table>
            </div>
           
        </div>
       
    </div>
</div>

@stop