@extends('layouts.auth')
@section('navcontent')
<div class="container">
    <div class="row justify-content-center">

        <div class="card shadow">
            <div class="card-header text-center"><strong>Users</strong></div>

            <div class="card-body">
                @include('includes.messages')
                @if(count($users) > 0)
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Branches</th>
                            <th width="200px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 1;
                        ?>
                        @foreach($users as $user)
                        <tr>
                            <td id="{{$user->id}}">{{ $i++}}</td>
                            <td>{{$user->firstname}} &nbsp; {{$user->lastname}}</td>
                            <td>{{$user->email}}</td>
                            <td> @foreach($user->roles as $role)
                            <label class="badge badge-secondary">
                            
                                      {{$role['name']}}&nbsp;
                               
                                </label>&nbsp;
                                
                                @endforeach
                                </td>
                                <td> @foreach($user->branches as $branch)
                            <label class="badge badge-secondary">
                            
                                      {{$branch['name']}}&nbsp;
                               
                                </label>&nbsp;
                                
                                @endforeach
                                </td>
                            <td>
                                <div class="d-flex align-items-center justify-content-around">
                                    <a href="{{ route('users.edit', $user->id)}}"><i
                                            class="fas text-warning fa-edit"></i></a>&nbsp;&nbsp;

                                    <a href="{{ route('users.index', $user->id)}}"><i
                                            class="fas text-danger fa-trash"></i></a>&nbsp;

                                            <!-- <form action="{{ route('send-push') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$user->id}}" />

                                        <input class="btn btn-primary" type="submit" value="Send Push">
                                    </form> -->
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-center">No user found!</p>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection