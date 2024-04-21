@extends('layouts.app')

@section('title', 'Pending Bookings')

@section('contents')

<div class="table-responsive">
    @if($pendingBookings->isNotEmpty())
    <table class="table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Date</th>
                <th>Time</th>
                <th>Pet Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendingBookings as $booking)
            <tr>
                <td>{{ $booking->user_id }}</td>
                <td>{{ $booking->date }}</td>
                <td>{{ $booking->time }}</td>
                <td>{{ $booking->pet_name }}</td>
                <td>{{ $booking->status }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.bookings.update', $booking->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <select class="form-control" name="status">
                                <option value="approved">Approve</option>
                                <option value="rejected">Reject</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No pending bookings available.</p>
    @endif
</div>
@endsection
