@extends('layouts.auth')
@section('navcontent')
<div class="container">
    <div>
        <p>
            <a href="{{ route('expense_categories.create') }}" class="btn btn-success">Add New</a>

        </p>
        <div>
            <div class="row justify-content-center">

                <div class="card shadow">
                    <div class="card-header text-center"><strong>Expense Categories</strong></div>

                    <div class="card-body">
                        @include('includes.messages')
                        @if(count($expense_categories) > 0)
                        <table class="table table-hover table-responsive">
                            <thead>
                                <tr>
                                    <td>Category ID</td>
                                    <td>Category Name</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                            $i = 1;
                        ?>
                                @foreach($expense_categories as $expense_category)
                                <tr>
                                    <td id="{{$expense_category->id}}">{{ $i++}}</td>
                                    <td>{{$expense_category->name}}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-around">

                                            <a href="{{ route('expense_categories.edit', $expense_category->id)}}"><i
                                                    class="fas text-warning fa-edit"></i></a>&nbsp;&nbsp;
                                            <a href="{{ route('expense_categories.destroy', $expense_category->id)}}"><i
                                                    class="fas text-danger fa-trash"></i></a>&nbsp;


                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p class="text-center">No category found!</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
        @endsection