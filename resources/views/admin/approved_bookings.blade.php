@extends('layouts.app')

@section('title', 'Approved Bookings')

@section('contents')

<div class="table-responsive">
    @if($approvedBookings->isNotEmpty())
    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Pet Name</th>
                <th>User Email</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($approvedBookings as $booking)
            <tr>
                <td>{{ $booking->date }}</td>
                <td>{{ $booking->time }}</td>
                <td>{{ $booking->pet_name }}</td>
                <td>{{ $booking->user_email }}</td>
                <td>{{ $booking->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No approved bookings available.</p>
    @endif
</div>
@endsection