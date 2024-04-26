@extends('layouts.app')

@section('contents')

<style>
   
    .action-column {
        width: 360px; 
    }
   
 
    table {
        width: 100%; 
        table-layout: auto; 
    }

</style>

<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h3 class="text-primary" style="font-family: 'Nonito', sans-serif; font-weight: semi-bold;">PENDING BOOKINGS</h3>
        </div>
    </div>
    <div class="table-responsive table-bordered table-striped table-wrapper">
        @if($pendingBookings->isNotEmpty())
        <style>
            .table-striped tbody tr:nth-of-type(odd) {
                background-color: #f1f7fe;
            }
        </style>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="bookingId-column"> ID</th> 
                    <th>Date</th>
                    <th>Time</th>
                    <th>Pet Name</th>
                    <th>User Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingBookings as $key => $booking) 
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->date }}</td>
                    <td>{{ $booking->time }}</td>
                    <td>{{ $booking->pet_name }}</td>
                    <td>{{ $booking->user_email }}</td>
                    <td>{{ $booking->status }}</td>
                    <td class="action-column">
                        <div class="btn-group">
                            <form method="POST" action="{{ route('admin.bookings.update', $booking->id) }}" class="d-flex">
                                @csrf
                                @method('PUT')
                                <div class="form-group mr-1">
                                    <select class="form-control" name="status">
                                        <option value="">Select Action</option>
                                        <option value="approved">Approve</option>
                                        <option value="rejected">Reject</option>
                                    </select>
                                </div>
                                <button type="submit " class="btn btn-primary flex-grow-1 mr-2" onclick="return validateForm()">Update</button>
                            </form>
                            <button class="btn btn-info btn-sm" onclick="viewDetails('{{ json_encode($booking) }}')">View Details</button>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination links -->
        {{ $pendingBookings->links() }}
        @else
        <p>No pending bookings available.</p>
        @endif
    </div>
</div>

<!-- Modal to display booking details -->
<div class="modal fade" id="bookingDetailsModal" tabindex="-1" role="dialog" aria-labelledby="bookingDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #ffa500; color: white;">
                <h5 class="modal-title" id="bookingDetailsModalLabel">BOOKING DETAILS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="bookingDetails"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary " style="background-color: #ffa500b5; " data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function validateForm() {
        var action = document.querySelector("select[name='status']").value;
        if (action === "") {
            alert("Please choose an action before updating the booking.");
            return false;
        }
        return true;
    }

    function viewDetails(bookingJson) {
        var booking = JSON.parse(bookingJson);
        // Construct the HTML for booking details
        var bookingDetails = "<div class='row'>";
        bookingDetails += "<div class='col-md-6'><strong>BOOKING ID:</strong></div><div class='col-md-6'>" + booking.id + "</div>";
        bookingDetails += "<div class='col-md-6'><strong>DATE:</strong></div><div class='col-md-6'>" + booking.date + "</div>";
        bookingDetails += "<div class='col-md-6'><strong>TIME:</strong></div><div class='col-md-6'>" + booking.time + "</div>";
        bookingDetails += "<div class='col-md-6'><strong>PET NAME:</strong></div><div class='col-md-6'>" + booking.pet_name + "</div>";
        bookingDetails += "<div class='col-md-6'><strong>PET TYPE:</strong></div><div class='col-md-6'>" + booking.pet_type + "</div>";
        bookingDetails += "<div class='col-md-6'><strong>BREED:</strong></div><div class='col-md-6'>" + booking.breed + "</div>";
        bookingDetails += "<div class='col-md-6'><strong>AGE:</strong></div><div class='col-md-6'>" + booking.age + "</div>";
        bookingDetails += "<div class='col-md-6'><strong>COLOR:</strong></div><div class='col-md-6'>" + booking.color + "</div>";
        bookingDetails += "<div class='col-md-6'><strong>SYMPTOMS:</strong></div><div class='col-md-6'>" + booking.symptoms + "</div>";
        bookingDetails += "<div class='col-md-6'><strong>SERVICE:</strong></div><div class='col-md-6'>" + booking.service_type + "</div>";
        bookingDetails += "<div class='col-md-6'><strong>USER EMAIL:</strong></div><div class='col-md-6'>" + booking.user_email + "</div>";
        bookingDetails += "<div class='col-md-6'><strong>STATUS:</strong></div><div class='col-md-6'>" + booking.status + "</div>";
        bookingDetails += "</div>";

        // Display the booking details in the modal
        document.getElementById('bookingDetails').innerHTML = bookingDetails;
        $('#bookingDetailsModal').modal('show');
    }
</script>

@endsection
