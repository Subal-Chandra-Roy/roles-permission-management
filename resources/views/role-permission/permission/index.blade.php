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
                            Permisisons
                            <a href="{{url('permissions/create')}}" class="btn btn-primary float-end">Add Permission</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($permissions as $permission)
                            <tr>
                                <td>{{$permission->id}}</td>
                                <td>{{$permission->name}}</td>
                                <td>

                                    <a href="{{ url('permissions/'. $permission->id .'/edit')}}" class="btn btn-success">Edit</a>



                                    <a href="{{ url('permissions/'. $permission->id .'/delete')}}" class="btn btn-danger">Delete</a>

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