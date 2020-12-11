@extends('layouts.auth')
@section('navcontent')
<div class="container">

    <h3 class="page-title">Expenses</h3>

    <p>
        <a href="{{ route('expense.create') }}" class="btn btn-success">Add New</a>


    </p>

    <div class="panel-body table-responsive">
        <table
            class="table table-bordered table-striped {{ count($expenses) > 0 ? 'datatable' : '' }} @can('expense_delete') dt-select @endcan">


            <thead>
                <tr>
                    <td>#</td>
                    <td>Expense Category</td>
                    <td>Branch</td>
                    <td>Entry Date</td>
                    <td>Amount</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                            $i = 1;
                        ?>
                @foreach($expenses as $expense)
                <tr>
                    <td id="{{$expense->id}}">{{ $i++}}</td>
                    <td id="{{$expense->id}}">{{ $expense->expense_category['name']}}</td>
                    <td id="{{$expense->id}}">{{$expense->branch['name']}}</td>
                    <td id="{{$expense->id}}">{{$expense->entry_date}}</td>
                    <td id="{{$expense->id}}">{{$expense->amount}} /-</td>
                    <td>
                        <div class="d-flex align-items-center justify-content-around">
                            <a href="{{ route('expense.show', $expense->id)}}"><i
                                    class="fas text-success fa-eye"></i></a>&nbsp;
                            <a href="{{ route('expense.edit', $expense->id)}}"><i
                                    class="fas text-warning fa-edit"></i></a>&nbsp;&nbsp;
                            <a href="{{ route('expense.destroy', $expense->id)}}"><i
                                    class="fas text-danger fa-trash"></i></a>&nbsp;


                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>
</div>
@endsection