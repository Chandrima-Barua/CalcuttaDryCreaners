@extends('layouts.auth')
@section('navcontent')
<div class="container">
    <div class="row justify-content-center">
        
            <div class="card shadow">
                <div class="card-header text-center"><strong>Notices</strong></div>

                <div class="card-body">
                    @include('includes.messages')
                    @if(count($notices) > 0)
                    <table class="table table-hover table-responsive">
                        <thead>
                            <tr>
                                <td>Notice ID</td>
                                <td>Title</td>
                                <td>Created</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $i = 1;
                        ?>
                            @foreach($notices as $notice)
                            <tr>
                                <td id="{{$notice->id}}">{{ $i++}}</td>
                                <td>{{$notice->title}}</td>
                                <td>{{date('d/m/Y', strtotime($notice->created_at))}}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-around">
                                       <a href="{{ route('notice.show', $notice->id)}}"><i class="fas text-warning fa-eye"></i></a>&nbsp;&nbsp;
                                        <a href="{{ route('notice.edit', $notice->id)}}"><i class="fas text-warning fa-edit"></i></a>&nbsp;&nbsp;
                                        <a href="{{ route('notice.destroy', $notice->id)}}"><i class="fas text-danger fa-trash"></i></a>&nbsp;
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-center">No notice found!</p>
                    @endif
                </div>
            
        </div>
    </div>
</div>
@endsection
