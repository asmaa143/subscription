@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Billing</div>

                <div class="card-body">
                    Free Trial
                    <div class="row">
                        @foreach($plans as $plan)
                        <div class="col-4 text-center">
                            <h3>{{$plan->name}}</h3>
                            <b>${{number_format($plan->price /100,2)}}</b>
                            <hr>
                            <a href="{{route('checkout',$plan->id)}}" class="btn btn-primary">Subscribe to {{$plan->name}}</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection