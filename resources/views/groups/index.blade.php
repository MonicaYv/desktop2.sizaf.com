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
  <h2>Group's List</h2>
  <p>Please add group as per requirment</p>
  <a href="{{ route('group-add') }}"><button type="button" class="btn btn-primary pull-right">Add Group</button></a>
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
        <th>Parent</th>
        <th>Actions</th>
      </tr>
    </thead>
          <tbody> 
                  @php $count = 1 @endphp
                  @if(!empty($groups))
                    @foreach($groups as $group)
                      <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $group->name }}</td>
                        <td>{{ $group->parentLevel }}</td>
                        <td>
                          <a href="{{ route('group-edit',['id' => $group->id]) }}"><button type="button" class="btn btn-primary">Edit</button></a>
                          <a href="{{ route('group-delete',['id' => $group->id]) }}"><button type="button" class="btn btn-danger">Delete</button></a>
                        </td>
                      </tr>
                     @php $count++; @endphp
                    @endforeach
                  @else
                      <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $group->name }}</td>
                        <td>{{ $group->parentID }}</td>
                        <td>
                          <a href="{{ route('group-edit',['id' => $group->id]) }}"><button type="button" class="btn btn-primary">Edit</button></a>
                          <a href="{{ route('group-delete',['id' => $group->id]) }}"><button type="button" class="btn btn-danger">Delete</button></a>
                        </td>
                      </tr>
                  @endif
          </tbody>
  </table>
  </div>
</div>

</body>
</html>
