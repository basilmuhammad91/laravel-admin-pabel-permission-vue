@extends('layouts.admin')

@section('content')
<div class="container pt-5">
    <div class="row">
          <div class="col-12">
            @include('layouts.alerts')
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Role Table</h3>

                <div class="card-tools">
                  <a href="{{route('role.create')}}" class="btn btn-primary">Create New Role</a>
                </div>
              </div>
              <!-- /.card-header -->

              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Role</th>
                      <th>Permission</th>
                      <th>Date Posted</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($roles as $role)
                    <tr>
                      <th>{{$role->id}}</th>
                      <th>{{$role->name}}</th>
                      <th>
                        @foreach($role->permissions as $permission)
                        <button class="btn btn-warning">{{$permission->name}}</button>
                        @endforeach 
                      </th>
                      <th>Date Posted</th>
                    </tr>
                    @endforeach
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
