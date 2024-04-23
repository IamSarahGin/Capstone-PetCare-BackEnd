@extends('layouts.app')

@section('title', 'Service Management')

@section('contents')

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <!-- Create Service Form -->
            <div class="card">
                <div class="card-header">
                    Create New Service
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.services.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="service_type">Service Type</label>
                            <input type="text" class="form-control" id="service_type" name="service_type" placeholder="Enter service type">
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <!-- Display List of Services -->
            <div class="card">
                <div class="card-header">
                    Active Services
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Service Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($services as $service)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $service->service_type }}</td>
                                    <td>
                                        <form action="{{ route('admin.services.soft-delete', $service->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure you want to soft delete this service?')">Soft Delete</button>
                                        </form>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editServiceModal{{ $service->id }}">Edit</button>
                                        
                                        <!-- Edit Service Modal -->
                                        <div class="modal fade" id="editServiceModal{{ $service->id }}" tabindex="-1" role="dialog" aria-labelledby="editServiceModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('admin.services.update', $service->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="edit_service_type">Service Type</label>
                                                                <input type="text" class="form-control" id="edit_service_type" name="service_type" value="{{ $service->service_type }}">
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Edit Service Modal -->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $services->links() }} <!-- Pagination Links -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <!-- Display List of Soft Deleted Services -->
            <div class="card">
                <div class="card-header">
                    Soft Deleted Services
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Service Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($softDeletedServices as $service)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $service->service_type }}</td>
                                    <td>
                                        <form action="{{ route('admin.services.restore', $service->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                        </form>
                                        <form action="{{ route('admin.services.delete-permanently', $service->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to permanently delete this service?')">Delete Permanently</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $softDeletedServices->links() }} <!-- Pagination Links -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
