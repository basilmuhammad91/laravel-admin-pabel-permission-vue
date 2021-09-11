@extends('layouts.admin')

@section('content')
<div class="container pt-5">
    <div class="row">
          <div class="col-12">
            @include('layouts.alerts')
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Permission Table</h3>

                <div class="card-tools">
                  <a href="{{route('permission.create')}}" class="btn btn-primary">Create New Permission</a>
                </div>
              </div>
              <!-- /.card-header -->

              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Date Posted</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($permissions as $permission)
                    <tr>
                      <td>{{$permission->id}}</td>
                      <td>{{$permission->name }}</td>
                      <td>{{$permission->created_at}}</td>
                      <td>
                        <a href="{{route('permission.edit', $permission->id)}}" class="btn btn-sm btn-info">Edit Permission</a>
                      </td>
                    </tr>
                    @endforeach()
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
</div>
@endsection
