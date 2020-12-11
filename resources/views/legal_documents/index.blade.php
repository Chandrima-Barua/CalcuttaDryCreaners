@extends('layouts.auth')
@section('navcontent')
<div class="container">
    <div class="row justify-content-center">

        <div class="card shadow">
            <div class="card-header text-center"><strong>Legal Documents</strong></div>

            <div class="card-body">
                @include('includes.messages')
                @if(count($legals) > 0)
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Legal Category</td>
                            <td>Number Input</td>
                            <td>Insurance</td>
                            <td>Tax Token</td>
                            <td>Fitness</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 1;
                        ?>
                        @foreach($legals as $legal)
                        <tr>
                            <td id="{{$legal->id}}">{{ $i++}}</td>

                            <td>
                                <label class="badge badge-secondary">

                                    {{$legal->legal_categories['name']}}&nbsp;

                                </label>&nbsp;


                            </td>
                            <td>
                                <label class="badge badge-secondary">Start Date :</label>
                                {{$legal->bike_starting}}<br>
                                <label class="badge badge-secondary">End Date</label>
                                {{$legal->bike_ending}}
                            </td>
                            <td>
                                <label class="badge badge-secondary">Start Date :</label>
                                {{$legal->insurance_starting}}<br>
                                <label class="badge badge-secondary">End Date</label>
                                {{$legal->insurance_ending}}
                            </td>
                            <td>
                                <label class="badge badge-secondary">Start Date :</label>
                                {{$legal->taxtoken_starting}}<br>
                                <label class="badge badge-secondary">End Date</label>
                                {{$legal->taxtoken_ending}}
                            </td>
                            <td>
                                <label class="badge badge-secondary">Start Date :</label>
                                {{$legal->fitness_starting}}<br>
                                <label class="badge badge-secondary">End Date</label>
                                {{$legal->fitness_ending}}
                            </td>

                            <td>
                                <div class="d-flex align-items-center justify-content-around">

                                    <a href="{{ route('legal_documents.edit', $legal->id)}}"><i
                                            class="fas text-warning fa-edit"></i></a>&nbsp;&nbsp;
                                    <a href="{{ route('legal_documents.destroy', $legal->id)}}"><i
                                            class="fas text-danger fa-trash"></i></a>&nbsp;
                                    <a href="{{ route('legal_documents.show', $legal->id)}}"><i
                                            class="fas text-success fa-eye"></i></a>&nbsp;
                                    <a href="{{ route('legal_documents.notification', $legal->id)}}"><i class="fa text-danger fa-bell"></i></a>&nbsp;

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-center">No documents found!</p>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection