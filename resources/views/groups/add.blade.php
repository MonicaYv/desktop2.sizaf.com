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
  <a href="{{ route('groups') }}"><button type="button" class="btn btn-default">Back</button></a>
  <div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4"></div>
    <div class="col-sm-4"></div>
  </div>                                                                                      
  <div class="table-responsive">          
  <form action="{{ route('group-create') }}" method="POST">
       @csrf
      <div class="form-group">
        <label for="email">Group Name:</label>
        <input type="text" class="form-control" id="email" placeholder="Enter Group name" name="name">
      </div>
      <div class="form-group">
         <label for="file">Parent group:</label>
        <input type="text" class="form-control" id="email" placeholder="Enter Parent" name="parentID">
      </div>
      <div class="form-group">
         <label for="file">Parent Level:</label>
        <input type="text" class="form-control" id="email" placeholder="Enter Parent" name="parentLevel">
      </div>
      <div class="form-group">
         <label for="file">Max Storage:</label>
        <input type="text" class="form-control" id="email" placeholder="Enter Parent" name="sizeMax">
      </div>
      <div class="form-group">
         <label for="file">Usable Storage:</label>
        <input type="text" class="form-control" id="email" placeholder="Enter Parent" name="sizeUse">
      </div>

      <div class="form-group">
        <label for="sel1">Permission:</label>
          <select class="form-control" id="sel1" name="permissionID">
             @foreach($permissions as $permission)
              <option value="{{ $permission->id }}">{{ $permission->name }}</option>
             @endforeach
          </select>
      </div>

      <button type="submit" class="btn btn-info">Create</button>
    </form>
  </div>
</div>

</body>
</html>
