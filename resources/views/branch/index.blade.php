@extends('layouts.auth')
@section('navcontent')
<div class="container">
    <div class="row justify-content-center">
        
            <div class="card shadow">
                <div class="card-header text-center"><strong>Branches</strong></div>

                <div class="card-body">
                    @include('includes.messages')
                    @if(count($branches) > 0)
                    <table class="table table-hover table-responsive">
                        <thead>
                            <tr>
                                <td>Branch ID</td>
                                <td>Branch Name</td>
                                <td>Address</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $i = 1;
                        ?>
                            @foreach($branches as $branch)
                            <tr>
                                <td id="{{$branch->id}}">{{ $i++}}</td>
                                <td>{{$branch->name}}</td>
                                <td>{{$branch->address}}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-around">

                                        <a href="{{ route('branch.edit', $branch->id)}}"><i class="fas text-warning fa-edit"></i></a>&nbsp;&nbsp;
                                        <a href="{{ route('branch.destroy', $branch->id)}}"><i class="fas text-danger fa-trash"></i></a>&nbsp;

                                    
                                        </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-center">No branch found!</p>
                    @endif
                </div>
            
        </div>
    </div>
</div>
@endsection
