@extends('layouts.app')

@section('title', 'Pet Type Management')

@section('contents')

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <!-- Create Pet Form -->
            <div class="card">
                <div class="card-header">
                    Create New Pet Type
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pets.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="pet_type">Pet Type</label>
                            <input type="text" class="form-control" id="pet_type" name="pet_type" placeholder="Enter pet type">
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <!-- Display List of Pets -->
            <div class="card">
                <div class="card-header">
                    Active Pets
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pet Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pets as $pet)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pet->pet_type }}</td>
                                    <td>
                                        <form action="{{ route('admin.pets.soft-delete', $pet->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure you want to soft delete this pet?')">Soft Delete</button>
                                        </form>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editPetModal{{ $pet->id }}">Edit</button>
                                        
                                        <!-- Edit Pet Modal -->
                                        <div class="modal fade" id="editPetModal{{ $pet->id }}" tabindex="-1" role="dialog" aria-labelledby="editPetModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editPetModalLabel">Edit Pet</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('admin.pets.update', $pet->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="edit_pet_type">Pet Type</label>
                                                                <input type="text" class="form-control" id="edit_pet_type" name="pet_type" value="{{ $pet->pet_type }}">
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Edit Pet Modal -->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $pets->links() }} <!-- Pagination Links -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <!-- Display List of Soft Deleted Pets -->
            <div class="card">
                <div class="card-header">
                    Soft Deleted Pets
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pet Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($softDeletedPets as $pet)

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pet->pet_type }}</td>
                                    <td>
                                        <form action="{{ route('admin.pets.restore', $pet->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                        </form>
                                        <form action="{{ route('admin.pets.delete-permanently', $pet->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to permanently delete this pet?')">Delete Permanently</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $softDeletedPets->links() }} <!-- Pagination Links -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
