<!-- In dashboard.blade.php -->

@extends('layouts.app')

@section('contents')
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <h2 class=" text-primary">PetCare Dashboard</h2S>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">Pending Bookings</div>
                    <div class="card-body">
                        <h3 class="text-primary">{{ $bookingCounts['pendingCount'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-success text-white">Approved Bookings</div>
                    <div class="card-body">
                        <h3 class="text-success">{{ $bookingCounts['approvedCount'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-danger text-white">Rejected Bookings</div>
                    <div class="card-body">
                        <h3 class="text-danger">{{ $bookingCounts['rejectedCount'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
