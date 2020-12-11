@extends('layouts.auth')
@section('navcontent')
<div class="container">

    <div class="row justify-content-center">

        <div class="card shadow">
            <div class="card-header text-center"><strong>Services</strong></div>

            <div class="card-body">
                @include('includes.messages')
                @if(count($services) > 0)
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <td>Service ID</td>
                            <td>Service Name</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $i = 1;
                        ?>
                        @foreach($services as $service)
                        <tr>
                            <td id="{{$service->id}}">{{ $i++}}</td>
                            <td>{{$service->name}}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-around">

                                    <a href="{{ route('services.edit', $service->id)}}"><i
                                            class="fas text-warning fa-edit"></i></a>&nbsp;&nbsp;
                                    <a href="{{ route('services.destroy', $service->id)}}"><i
                                            class="fas text-danger fa-trash" ></i></a>&nbsp;
                                            <!-- <a href="#popupDialog"  data-rel="popup" data-position-to="window" data-transition="pop"
                    class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-icon-delete ui-btn-icon-left ui-btn-b" id="servicedelete"><i class="fas text-danger fa-trash" ></i></a>&nbsp; -->

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
              
                <!-- <div data-role="popup" id="popupDialog" data-overlay-theme="b" data-theme="b" data-dismissible="false"
                    style="max-width:400px;">
                        <div data-role="header" data-theme="a">
                            <h1>Delete Page?</h1>
                            </div>
                        <div role="main" class="ui-content">
                                <h3 class="ui-title">Are you sure you want to delete this page?</h3>
                            <p>This action cannot be undone.</p>
                                <a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b"
                            data-rel="back">Cancel</a>
                                <a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b"
                            data-rel="back" data-transition="flow">Delete</a>
                            </div>
                </div> -->
                @else
                <p class="text-center">No services found!</p>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection