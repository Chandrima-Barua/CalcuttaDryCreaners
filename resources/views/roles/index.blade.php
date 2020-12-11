@extends('layouts.auth')
@section('navcontent')
<div class="container">
    <div class="row justify-content-center">
        
            <div class="card shadow">
                <div class="card-header text-center"><strong>Roles</strong></div>

                <div class="card-body">
                    @include('includes.messages')
                    @if(count($roles) > 0)
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
                            @foreach($roles as $role)
                            <tr>
                                <td id="{{$role->id}}">{{ $i++}}</td>
                                <td>{{$role->name}}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-around">

                                        <a href="{{ route('roles.edit', $role->id)}}"><i class="fas text-warning fa-edit"></i></a>&nbsp;&nbsp;
                                        <a href="{{ route('roles.destroy', $role->id)}}"><i class="fas text-danger fa-trash"></i></a>&nbsp;

                                    
                                        </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-center">No role found!</p>
                    @endif
                </div>
            
        </div>
    </div>
</div>
@endsection