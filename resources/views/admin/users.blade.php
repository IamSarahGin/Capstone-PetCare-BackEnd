@extends('layouts.app')

@section('contents')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h3 class="text-primary" style="font-family: 'Nonito', sans-serif; font-weight: semi-bold;">ADMIN USER MANAGEMENT</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 ">
            <!-- Create Admin User Form -->
            <div class="card">
                <div class="card-header" style="background-color:  #f1f7fe;">
                    Create New Admin User
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <!-- Display List of Admin Users -->
            <div class="card">
                <div class="card-header" style="background-color:  #f1f7fe;">
                    Active Admin Users
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($adminUsers as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <form action="{{ route('admin.users.soft-delete', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure you want to soft delete this admin user?')">Soft Delete</button>
                                        </form>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editAdminUserModal{{ $user->id }}">Edit</button>

                                        <!-- Edit Admin User Modal -->
                                        <div class="modal fade" id="editAdminUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editAdminUserModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editAdminUserModalLabel">Edit Admin User</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="edit_name">Name</label>
                                                                <input type="text" class="form-control" id="edit_name" name="name" value="{{ $user->name }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="edit_email">Email</label>
                                                                <input type="email" class="form-control" id="edit_email" name="email" value="{{ $user->email }}">
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Edit Admin User Modal -->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $adminUsers->links() }} <!-- Pagination Links -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <!-- Display List of Soft Deleted Admin Users -->
            <div class="card">
                <div class="card-header" style="background-color: #f1f7fe;">
                    Soft Deleted Admin Users
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($softDeletedAdminUsers as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                        </form>
                                        <form action="{{ route('admin.users.delete-permanently', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this admin user permanently?')">Delete Permanently</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $softDeletedAdminUsers->links() }} <!-- Pagination Links -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
