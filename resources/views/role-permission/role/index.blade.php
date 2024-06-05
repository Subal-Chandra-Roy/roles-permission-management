<x-app-web-layout>
    @include('role-permission.nav-link')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                <div class="alert alert-success">{{session('status')}}</div>
                @endif
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>
                            Roles
                            <a href="{{url('roles/create')}}" class="btn btn-primary float-end">Add Role</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($roles as $role)
                            <tr>
                                <td>{{$role->id}}</td>
                                <td>{{$role->name}}</td>
                                <td>
                                    <a href="{{ url('roles/'. $role->id .'/give-permissions')}}" class="btn btn-primary">Add/Edit Role Permission</a>

                                    
                                    <a href="{{ url('roles/'. $role->id .'/edit')}}" class="btn btn-success">Edit</a>
                                    

                                    
                                    <a href="{{ url('roles/'. $role->id .'/delete')}}" class="btn btn-danger">Delete</a>
                                    

                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-web-layout>