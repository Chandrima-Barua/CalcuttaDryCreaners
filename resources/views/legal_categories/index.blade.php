@extends('layouts.auth')
@section('navcontent')
<div class="container">
    <div class="row justify-content-center">
        
            <div class="card shadow">
                <div class="card-header text-center"><strong>Roles</strong></div>

                <div class="card-body">
                    @include('includes.messages')
                    @if(count($legal_categories) > 0)
                    <table class="table table-hover table-responsive">
                        <thead>
                            <tr>
                                <td>Role ID</td>
                                <td>Role Name</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $i = 1;
                        ?>
                            @foreach($legal_categories as $legal_category)
                            <tr>
                                <td id="{{$legal_category->id}}">{{ $i++}}</td>
                                <td>{{$legal_category->name}}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-around">

                                        <a href="{{ route('legal_categories.edit', $legal_category->id)}}"><i class="fas text-warning fa-edit"></i></a>&nbsp;&nbsp;
                                        <a href="{{ route('legal_categories.destroy', $legal_category->id)}}"><i class="fas text-danger fa-trash"></i></a>&nbsp;

                                        </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-center">No Legal Category found!</p>
                    @endif
                </div>
            
        </div>
    </div>
</div>
@endsection