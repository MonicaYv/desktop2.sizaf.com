@extends('layouts.common')
@section('title', 'File Manager')
@section('styles')
<!-- <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'].'dashbord.css') }}">
<link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'].'filemanager.css') }}"> -->

@endsection
@section('content')

@php
// Split the path into components
///print_r($path);die;
$pathComponents = explode('/', base64UrlDecode($path));

// Remove the last elements
//array_pop($pathComponents);

// Reassemble the path
$updatedPath = implode('/', $pathComponents);
if(empty($updatedPath)){
    $updatedPath = '/';
}
//$pathnew = base64UrlEncode($path);
@endphp
    <main class="flex w-full h-full flex cm font-size-14">
      <!-- Sidebar -->
      @include('layouts.sidebar')
      <div class="flex-grow h-100 main">
        <div class="flex w-full h-full flex-col content">
          <div class="px-4 md:px-6 py-3 py-6 pb-2 md:pb-6">
            <div class="flex items-center gap-4">
              <span class="text-xl text-c-black">File</span>
            </div>
          </div>
          <!-- topTaskbar in desktops -->
          @include('layouts.filemanager-header')
          <!--Main content -->
          <div class="relative loaddetails allapplist h-full overflow-y-auto scroll">
            <!--grid container -->
            <!-- <div id="gridContainer" class="grid grid-cols-12 gap-4 transition-all duration-300 p-4 overflow-y-auto">
              
            </div> -->
            <!--table container -->
            @include('layouts.columnview')
            <!--panes-->
            <div id="panel" class="resizable-sidebar hidden md:w-4/12 xl:w-1/5">
              <div class="resizer"></div>
              <!--detailpan-->
              @include('layouts.detailpan')
              <!--preview pane-->
              @include('layouts.previewpan')
            </div>
          </div>
          <!--upload popup-->
          <!--share popup-->
        </div>
      </div>
      <!--Iframe popup-->
    </main>

@endsection
@section('scripts')

<!--poup-->
<!-- <script src="{{ asset($constants['JSFILEPATH'].'filemanager.js') }}"></script> -->
<script src="{{ asset($constants['JSFILEPATH'].'sidebar.js') }}" ></script>
<script src="{{ asset($constants['JSFILEPATH'].'taskbar.js') }}" ></script>
<script src="{{ asset($constants['JSFILEPATH'].'tabs.js') }}" ></script>

<script>
  // const desktopapp = @json(route('desktopapp'));
  // const createFolderRoute = @json(route('createfolder'));
  // const createFileRoute = @json(route('createfile'));
  // const showFileDetail = @json(route('showpathdetail'));
  let path = @json($path);
  let navbar = false;
</script>
    <script>
    $('.navbarhead').hide();
       document.addEventListener("DOMContentLoaded", () => {
      //  document.querySelector('.newfiledropdown').addEventListener('click', function() {
      //   document.querySelector('.newfiledropdownoption').classList.toggle('hidden');
      // });
           
        const links = {
          'desktop.html': 'link-desktop',
          'Recent.html': 'link-recent',
          'downloads.html': 'link-downloads',
          'filemanager.html': 'link-filemanager',
          'documents.html': 'link-documents',
          'applications.html': 'link-applications'
        };

  }
  document.addEventListener("DOMContentLoaded", () => {
    //  document.querySelector('.newfiledropdown').addEventListener('click', function() {
    //   document.querySelector('.newfiledropdownoption').classList.toggle('hidden');
    // });           
    const links = {
      'desktop.html': 'link-desktop',
      'Recent.html': 'link-recent',
      'downloads.html': 'link-downloads',
      'filemanager.html': 'link-filemanager',
      'documents.html': 'link-documents',
      'applications.html': 'link-applications'
    };

    const currentPage = window.location.pathname.split('/').pop();

    const activeLinkId = links[currentPage];
    if (activeLinkId) {
      const activeLink = document.getElementById(activeLinkId);
      if (activeLink) {
        activeLink.classList.add('bg-black', 'text-orange-500', 'font-semibold');
      }
    }
      
    // Show path details based on the given path
    showapathdetail(path);
        
    function showapathdetail(path){
        $.ajax({
            url: showFileDetail,
            method: 'GET',
            data: {path:path},
            success: function (response) {
                $('.loaddetails').html(response.html);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        }); 
    }
        
    // search functionality
    $('#searchFiles').on('keyup', function() {
      var query = $(this).val().trim();
        if (query.length > 0) {
            $.ajax({
                url: "{{ route('fileExp-list') }}", 
                method: 'GET',
                data: { searchFiles: query, path: path },
                success: function(data) {
                  $('.loaddetails').html(data.html);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
          showapathdetail(path);
        }
      });            
    });  
    
  </script>
@endsection