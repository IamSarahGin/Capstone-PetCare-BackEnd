@extends('layouts.app')

@section('title', 'Rejected Bookings')

@section('contents')

<div class="container">
    <div class="table-responsive">
        @if($rejectedBookings->isNotEmpty())
        <table class="table table-bordered">
            <thead>
                <tr>
                    
                    <th>Date</th>
                    <th>Time</th>
                    <th>Pet Name</th>
                    <th>User ID</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rejectedBookings as $booking)
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
        <!-- Pagination links -->
        {{ $rejectedBookings->links() }}
        @else
        <p>No rejected bookings available.</p>
        @endif
    </div>
</div>
@endsection
