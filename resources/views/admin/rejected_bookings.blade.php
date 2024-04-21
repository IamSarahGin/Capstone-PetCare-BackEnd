@extends('layouts.app')

@section('title', 'Rejected Bookings')

@section('contents')

<div class="table-responsive">
    @if($rejectedBookings->isNotEmpty())
    <table class="table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Date</th>
                <th>Time</th>
                <th>Pet Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rejectedBookings as $booking)
            <tr>
                <td>{{ $booking->user_id }}</td>
                <td>{{ $booking->date }}</td>
                <td>{{ $booking->time }}</td>
                <td>{{ $booking->pet_name }}</td>
                <td>{{ $booking->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No rejected bookings available.</p>
    @endif
</div>
@endsection