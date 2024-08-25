<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Roles List</h2>
  <p>Please add role's as per requirment</p>
  <a href="{{ route('role-add') }}"><button type="button" class="btn btn-primary pull-right">Add Role</button></a>
  <a href="{{ route('users') }}"><button type="button" class="btn btn-default">Back</button></a>
  <div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4"></div>
    <div class="col-sm-4"></div>
  </div>                                                                                      
  <div class="table-responsive">          
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Upload-Size</th>
        <th>Description</th>
        <th>Actions</th>
      </tr>
    </thead>
          <tbody> 
                  @php $count = 1 @endphp
                  @if(!empty($roles))
                    @foreach($roles as $role)
                      <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->upload_limit }}</td>
                        <td>{{ $role->description }}</td>
                        <td>
                          <a href="{{ route('role-edit',['id' => $role->id]) }}"><button type="button" class="btn btn-primary">Edit</button></a>
                          <a href="{{ route('role-delete',['id' => $role->id]) }}"><button type="button" class="btn btn-danger">Delete</button></a>
                        </td>
                      </tr>
                     @php $count++; @endphp
                    @endforeach
                  @else
                      <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->upload_limit }}</td>
                        <td>{{ $role->description }}</td>
                        <td>
                          <a href="{{ route('role-edit',['id' => $role->id]) }}"><button type="button" class="btn btn-primary">Edit</button></a>
                          <a href="{{ route('role-delete',['id' => $role->id]) }}"><button type="button" class="btn btn-danger">Delete</button></a>
                        </td>
                      </tr>
                  @endif
          </tbody>
  </table>
  </div>
</div>

</body>
</html>
