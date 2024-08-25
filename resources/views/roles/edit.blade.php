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
    <form action="{{ route('role-update',['id' => $role->id]) }}" method="POST">
       @csrf
      <div class="form-group">
        <label for="email">Role Name:</label>
        <input type="text" class="form-control" id="email" placeholder="Enter email" name="name" value="{{ $role->name }}">
      </div>
      <div class="form-group">
        <label for="pwd">Upload Limit(GB):</label>
        <input type="text" class="form-control" id="pwd" placeholder="Enter password" name="upload_limit" value="{{ $role->upload_limit }}">
      </div>
      <div class="form-group">
         <label for="comment">Description:</label>
         <textarea class="form-control" rows="3" id="comment" name="description">{{ $role->description }}</textarea>
      </div>
      <div class="form-group">
         <label for="file">File Manage: </label>
        <div class="checkbox"> 
          <label>
          <input type="checkbox" id="file" name="file_manage_settings[]" value="preview"
            @php echo in_array('preview', $role->file_manage_settings) ? 'checked' : '' @endphp > Preview</label>
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="search"
             @php echo in_array('search', $role->file_manage_settings) ? 'checked' : '' @endphp> Search</label>
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="download"
            @php echo in_array('download', $role->file_manage_settings) ? 'checked' : '' @endphp> Download</label>
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="new-file"
            @php echo in_array('new-file', $role->file_manage_settings) ? 'checked' : '' @endphp> New File</label>
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="upload"
            @php echo in_array('upload', $role->file_manage_settings) ? 'checked' : '' @endphp> Upload</label>
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="share"
            @php echo in_array('share', $role->file_manage_settings) ? 'checked' : '' @endphp> Share</label>
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="edit"
            @php echo in_array('edit', $role->file_manage_settings) ? 'checked' : '' @endphp> Edit</label>
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="delete"
            @php echo in_array('delete', $role->file_manage_settings) ? 'checked' : '' @endphp> Delete</label>
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="move"
            @php echo in_array('move', $role->file_manage_settings) ? 'checked' : '' @endphp> Move</label>
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="compress"
            @php echo in_array('compress', $role->file_manage_settings) ? 'checked' : '' @endphp> Compression</label>
          <label><input type="checkbox" id="file" name="file_manage_settings[]" value="decompress"
            @php echo in_array('decompress', $role->file_manage_settings) ? 'checked' : '' @endphp> Decompress</label>
        </div>
      </div>

      <div class="form-group">
         <label for="file">User Operation:</label>
        <div class="checkbox">
          <label><input type="checkbox" id="file" name="user_settings[]" value="config_modify"
            @php echo in_array('config_modify', $role->user_settings) ? 'checked' : '' @endphp>Configuration Modification</label>
          <label><input type="checkbox" id="file" name="user_settings[]" value="operation"
            @php echo in_array('operation', $role->user_settings) ? 'checked' : '' @endphp>Starred operation</label>
        </div>
      </div>
      <button type="submit" class="btn btn-info">Update</button>
    </form>
  </div>
</div>

</body>
</html>
