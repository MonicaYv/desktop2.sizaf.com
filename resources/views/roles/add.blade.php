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
  <a href="{{ route('roles') }}"><button type="button" class="btn btn-default">Back</button></a>
  <div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4"></div>
    <div class="col-sm-4"></div>
  </div>                                                                                      
  <div class="table-responsive">          
    <form action="{{ route('role-create') }}" method="POST">
       @csrf
      <div class="form-group">
        <label for="email">Role Name:</label>
        <input type="text" class="form-control" id="email" placeholder="Enter email" name="name">
      </div>
      <div class="form-group">
        <label for="pwd">Upload Limit(GB):</label>
        <input type="text" class="form-control" id="pwd" placeholder="Enter password" name="upload_limit">
      </div>
      <div class="form-group">
         <label for="comment">Description:</label>
         <textarea class="form-control" rows="3" id="comment" name="description"></textarea>
      </div>
      <div class="form-group">
         <label for="file">File Manage:</label>
        <div class="checkbox">
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="preview"> Preview</label>
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="search"> Search</label>
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="download"> Download</label>
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="new-file"> New File</label>
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="upload"> Upload</label>
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="share"> Share</label>
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="edit"> Edit</label>
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="delete"> Delete</label>
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="move"> Move</label>
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="compress"> Compression</label>
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="decompress"> Decompress</label>
        </div>
      </div>

      <div class="form-group">
         <label for="file">User Operation:</label>
        <div class="checkbox">
          <label><input type="checkbox" id="file" name="user_settings[]" value="config_modify">Configuration Modification</label>
          <label><input type="checkbox" id="file" name="user_settings[]" value="operation">Starred operation</label>
        </div>
      </div>
      <button type="submit" class="btn btn-info">Create</button>
    </form>
  </div>
</div>

</body>
</html>
