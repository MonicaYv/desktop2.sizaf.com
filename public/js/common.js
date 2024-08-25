

// start right click
const container = $(".allapplist");
const appDiv = $(".allapplist .app");
appDiv.on("click", (event) => {
   event.stopPropagation();
   const checkbox = appDiv.find('input[type="checkbox"]');
   if (checkbox.length) {
     checkbox.prop("checked", !checkbox.prop("checked"));
   }
 });

 const checkbox = appDiv.find('input[type="checkbox"]');
 if (checkbox.length) {
   checkbox.on("click", (event) => {
     event.stopPropagation();
   });
 }



// Right Click Functionality
$(document).ready(function () {
 const appContextMenu = $("#app-contextmenu");
 const dashboardContextMenu = $("#context-menu");
 const dashboard = $(".allapplist .dashboard");
 const appDivs = $(".allapplist .app");
 const arrowIcons = $(".allapplist .app-tools i");

 // Function to position and show a menu
 function positionAndShowMenu(menu, event) {
   closeAllContainers();
  menu.css("display", "block").css("visibility", "hidden");
   // Calculate positions and available space
      
   const menuRect = menu[0].getBoundingClientRect();
   const viewportWidth = $(window).width();
   const viewportHeight = $(window).height();

   // Initial positioning: Prioritize placing the menu to the right
   let top = event.clientY;
   let left = event.clientX;

   // Check if there's enough space on the right, accounting for a small margin
   if (left + menuRect.width + 10 < viewportWidth) {
     // If so, place it on the right
   } else {
     // If not enough space on the right, place it on the left
     left -= menuRect.width;
   }

   // Adjust if overflowing at the top
   if (top + menuRect.height > viewportHeight) {
     // Try placing above first
     top = event.clientY - menuRect.height;
     if (top < 0) {
       // If still overflowing, adjust to fit below
       top = Math.max(0, viewportHeight - menuRect.height);
     }
   }

   // Ensure the menu is within the screen
   top = Math.max(0, top);
   left = Math.max(0, left);

   menu.css({
     top: top + "px",
     left: left + "px",
     visibility: "visible"
   }).removeClass("hidden").css("display", "block");
   
 }
   // Show submenu on hover
       $(document).on('mouseenter', '.context-menu li', function() {
       const submenu = $(this).find(".submenu");

       if (submenu.length) {
           submenu.removeClass("hidden").css("display", "block");

           // Adjust submenu position
           const submenuRect = submenu[0].getBoundingClientRect();
           const screenWidth = $(window).width();
           const screenHeight = $(window).height();

           // Handle right overflow
           if (submenuRect.right > screenWidth) {
               submenu.css("left", `-${submenuRect.width}px`);
           }

           // Handle left overflow
           if (submenuRect.left < 50) {
               submenu.css("left", `${$(this).outerWidth()}px`);
           }

           // Handle bottom overflow
           if (submenuRect.bottom > screenHeight) {
               submenu.css("top", `-${submenuRect.height - $(this).outerHeight()}px`);
           }

           // Handle top overflow
           if (submenuRect.top < 0) {
               submenu.css("top", `${$(this).outerHeight()}px`);
           }
       }
   });

   $(document).on('mouseleave', '.context-menu li', function() {
       const submenu = $(this).find(".submenu");
       if (submenu.length) {
           submenu.addClass("hidden").css("display", "none");
       }
   });

   $(document).on('click', '.context-menu li', function() {
       $("#app-contextmenu").addClass("hidden").css("display", "none");
       $("#context-menu").addClass("hidden").css("display", "none");

  });

 function closeAllContainers() {
   appContextMenu.hide();
   dashboardContextMenu.hide();
 }

 $(document).on("contextmenu", function (event) {
   event.preventDefault();
   
   const target = $(event.target);

  

   if (target.closest(".allapplist .app").length) {
      let contexttypes = target.closest(".allapplist .app").attr('data-option');
      $('.fimanagertoolpanel').addClass('disabledicon');

// select app 
   let thisApp = target.closest('.allapplist .app');
   let selectapp = target.closest(".allapplist .app .openiframe");
   $('.allapplist .app .selectapp').removeClass("selectedfile");
   $('.allapplist .app').removeClass("desktopapp-clicked");
   $('.allapplist .app .app-tools').addClass("invisible");
   $('.allapplist .app .appcheckbox').prop('checked', false);
      selectapp.addClass('selectedfile');
    thisApp.addClass('desktopapp-clicked');
    let filetype = selectapp.data('filetype');
    if(filetype =='folder' || filetype =='file'){
         $('.fimanagertoolpanel').removeClass('disabledicon');
    }
// end selection
       contextMenuList(contexttypes);
     positionAndShowMenu(appContextMenu, event);
   } else if (target.closest(".allapplist").length) {
       contextMenuList('rightclick');
       $('.allapplist .app').removeClass("desktopapp-clicked");
       $('.allapplist .app .selectapp').removeClass("selectedfile");
       $('.fimanagertoolpanel').addClass('disabledicon');
     positionAndShowMenu(dashboardContextMenu, event);
   } else {
     closeAllContainers();
   }
 });

 $(document).on('click', '.allapplist .app-tools i', function(event) {
       event.stopPropagation();
       $('.fimanagertoolpanel').addClass('disabledicon');
       // select app 
       let thisApp = $(this).closest('.app');
       let selectapp = $(this).closest('.openiframe');
       $('.allapplist .app .selectapp').removeClass("selectedfile");
        $('.allapplist .app').removeClass("desktopapp-clicked");
        $('.allapplist .app .app-tools').addClass("invisible");
        $('.allapplist .app .appcheckbox').prop('checked', false);
          selectapp.addClass('selectedfile');
        thisApp.addClass('desktopapp-clicked');
        let filetype = selectapp.data('filetype');
        if(filetype =='folder' || filetype =='file'){
             $('.fimanagertoolpanel').removeClass('disabledicon');
        }
        let contexttypes = $(this).closest(".app").attr('data-option');
        contextMenuList(contexttypes);
        
       // Hide dashboard context menu
       $('#context-menu').addClass('hidden').css('display', 'none');
       // Show the app context menu and position it
       positionAndShowMenu(appContextMenu, event);
   });

 
 $(document).on("click", function () {
   closeAllContainers();
 });
});

 //// end right click
/// desktop apps
 desktoplightapp();
   function desktoplightapp(sort_by = null, sort_order = null) {
    const data = {};
    if(sort_by) {
        data.sort_by = sort_by;
    }
    if (sort_order) {
        data.sort_order = sort_order;
    }
           $.ajax({
               url: desktopapp,
               method: 'GET',
               data: data,
               success: function (response) {
                   // Update the app list container with the updated list
                   $('.desktop-apps').html(response.html);
               },
               error: function (xhr, status, error) {
                   console.error(xhr.responseText);
               }
           });
           
           
       }
       function showapathdetail(path,sort_by = null, sort_order = null){
        const data = {};
        data.path = path
            if(sort_by) {
                data.sort_by = sort_by;
            }
            if (sort_order) {
                data.sort_order = sort_order;
            }
                $.ajax({
            url: showFileDetail,
            method: 'GET',
            data: data,
            success: function (response) {
                // Update the app list container with the updated list
                $('.loaddetails').html(response.html);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
        
        
    }


       /// Desktop app end
       //contextMenuList
   function contextMenuList(type){
           $.ajax({
               url: contextmenu,
               method: 'GET',
               data: {type:type},
               success: function (response) {
                   if(type=='rightclick'){
                       $('#context-menu').html(response.html);
                   }else{
                       $('#app-contextmenu').html(response.html);
                   }
                   
               },
               error: function (xhr, status, error) {
                   console.error(xhr.responseText);
               }
           });
           
           
       }

       /// end context menu
       /// file functions
       $(document).on('click', '.context-menulist .refreshButton', function (e) {
            e.preventDefault();
            e.stopPropagation();
            location.reload();
       });
       $(document).on('click', '.context-menulist .createFolderFunction', function (e) {
            e.preventDefault();
            e.stopPropagation();
            createFolderFunction();
        });
        $(document).on('click', '.context-menulist .createFileFunction', function (e) {
            e.preventDefault();
            e.stopPropagation();
            let filetype = $(this).data('type');
            createFileFunction(filetype);
        });

        $(document).on('click', '.context-menulist .resizeFunction', function (e) {
            e.preventDefault();
            e.stopPropagation();
            let filetype = $(this).data('type');
            $('.allapplist .app').addClass(filetype);
        });
        $(document).on('click', '.context-menulist .sortFunction', function (e) {
            e.preventDefault();
            e.stopPropagation();
            let filetype = $(this).data('type');
            filetypearr = filetype.split('-');
            desktoplightapp(filetypearr[0],filetypearr[1]);
            showapathdetail(path,filetypearr[0],filetypearr[1]);
        });

        $(document).on('click', '.context-menulist .resizeFunction', function (e) {
            e.preventDefault();
            e.stopPropagation();
            let filetype = $(this).data('type');
            let sizeclasses = ['tiny','small','big','medium','oversize'];
            sizeclasses.forEach(element => {
                $('.allapplist .app').removeClass(element+'-wraper');
                $('.allapplist .app .imagewraper').removeClass(element);
            });
            $('.allapplist .app').addClass(filetype+'-wraper');
            $('.allapplist .app .imagewraper').addClass(filetype);
        });


        // app menus

        // open app by rightclick
        $(document).on('click', '.context-menulist .openFunction', function (e) {
            e.preventDefault();
            e.stopPropagation();
            if($('.selectedfile').hasClass('openiframe')){
                const appkey = $('.selectedfile').attr('data-appkey');
                const filekey = $('.selectedfile').attr('data-filekey');
                const filetype = $('.selectedfile').attr('data-filetype');
                const apptype = $('.selectedfile').attr('data-apptype');
                const originalIcon = $('.selectedfile').find('.icondisplay');
                const imgicon =  $('#iframeheaders #iframeiconimage'+filetype+appkey);
                animateIcon(imgicon, originalIcon, function() {
                    const iframedata = {appkey:appkey,filekey:filekey,filetype:filetype,apptype:apptype};
                    openiframe(iframedata)
                }); 
            }else{
                let url = $('.selectedfile').attr('href');
                window.location.href = url;
            }
            $('.selectapp').removeClass('.selectedfile');
        });

        // open app by dblclick
        $(document).on('dblclick', '.allapplist .selectapp', function (e) {
            e.preventDefault();
            if($(this).hasClass('openiframe')){
                const appkey = this.getAttribute('data-appkey');
                const filekey = this.getAttribute('data-filekey');
                const filetype = this.getAttribute('data-filetype');
                const apptype = this.getAttribute('data-apptype');
                const originalIcon = $(this).find('.icondisplay');
                const imgicon =  $('#iframeheaders #iframeiconimage'+filetype+appkey);
                animateIcon(imgicon, originalIcon, function() {
                    const iframedata = {appkey:appkey,filekey:filekey,filetype:filetype,apptype:apptype};
                    openiframe(iframedata);
                 
                });           
             }else{
                    let url = $(this).attr('href');
                    window.location.href = url;
            }
        });



        // cut file 
         // rename 
         $(document).on('click', '.context-menulist .renameFunction', function (e) {
            e.preventDefault();
            const filekey = $('.selectedfile').attr('data-filekey');
            const filetype = $('.selectedfile').attr('data-filetype');
            
            // Target the input elements based on filekey and filetype
            const inputWrapper = $('#inputWrapper' + filetype + filekey);
            const inputField = $('#inputField' + filetype + filekey);
            
            // Modify the input field for renaming
            inputField.removeClass('text-white').addClass('text-black');
            inputField.removeAttr('disabled').removeClass('appinputtext').show().focus();
        
            // Handle click outside the input to finalize renaming
            $(document).one('click', function(event) {
                if (!inputWrapper.is(event.target) && inputWrapper.has(event.target).length === 0) {
                    // Disable the input field and add the necessary classes back
                    inputField.attr('disabled', true).addClass('appinputtext');
                    $('.openiframe').removeClass('selectedfile');
                    
                    // Call the rename function with the new name
                    renameFunction(filekey, filetype, inputField.val()); 
                }
            });
        
            // Stop the propagation to avoid immediate closing
            inputWrapper.on('click', function(event) {
                event.stopPropagation();
            });
        });
        

        // $(document).one('click', function(event) {
        //     const filekey = $('.selectedfile').attr('data-filekey');
        //     const filetype = $('.selectedfile').attr('data-filetype');
        //             /// rename
        //     const inputWrapper = $('#inputWrapper'+filetype+filekey);
        //     const inputField = $('#inputField'+filetype+filekey);
        //     if (!inputWrapper.is(event.target) && inputWrapper.has(event.target).length === 0) {
        //         inputField.attr('disabled'," ");
        //         inputField.addClass('appinputtext');
        //         $('.selectapp').removeClass('.selectedfile');
        //         renameFunction(filekey,filetype,inputField.val()); 
                 
        //         // Update text display with input value
        //     }
        // });
        //// cut copy paste 
        
        $(document).on('click', '.context-menulist .copyFunction', function (e) {
            e.preventDefault();
                const filekey = $('.selectedfile').attr('data-filekey');
                const filepath = $('.selectedfile').attr('data-path');
                const filetype = $('.selectedfile').attr('data-filetype');
                copyFunction(filepath,'copy',filetype,filekey);
                $('.selectapp').removeClass('.selectedfile');
         });
         $(document).on('click', '.context-menulist .cutFunction', function (e) {
            e.preventDefault();
                const filekey = $('.selectedfile').attr('data-filekey');
                const filepath = $('.selectedfile').attr('data-path');
                const filetype = $('.selectedfile').attr('data-filetype');
                copyFunction(filepath,'cut',filetype,filekey);
                $('.selectapp').removeClass('.selectedfile');
         });
         $(document).on('click', '.context-menulist .pasteFunction', function (e) {
            e.preventDefault();
            pasteFunction(path);
         });

     // Minimize button functionality
     $(document).on('click', '#alliframelist .minimizeiframe-btn', function() {
        var iframeId = $(this).data('iframe-id');
        var iframePopup = $('#alliframelist #iframepopup' + iframeId);
        const iframe = $('#alliframelist #iframepopup'+iframeId);
        if (!iframe.hasClass('minimized')) {
            iframe.addClass("minimized");
            iframe.removeClass("fall-down");
            minimized = true;
            setTimeout(() => {
            //    iframe.addClass("hidden");
            }, 600);
        }
        
    });
    
    // Close button functionality
        $(document).on('click', '#alliframelist .closeiframe-btn', function() {
            const appkey = this.getAttribute('data-appkey');
            const filekey = this.getAttribute('data-filekey');
            const filetype = this.getAttribute('data-filetype');
            const fileid = this.getAttribute('data-iframefile-id');
            closeiframe(appkey,filekey,fileid,filetype);
        });
    
        // Maximize button functionality
        $(document).on('click', '#alliframelist .maximizeiframe-btn', function() {
            var iframeId = $(this).data('iframe-id');
            var iframePopup = $('#alliframelist #iframepopup' + iframeId);
            iframePopup.toggleClass('maximized');
        });


        /// click iframe icon 
        $(document).on('click', '#iframeheaders .iframemainheadericon', function() {
            var iframeId = $(this).data('iframe-id');
            var iframefileId = $(this).data('iframefile-id');
            let img = $(this).find('.app-icon');

            /// animation close
            var popupcount = $(this).data('popup-count');
            if(popupcount >1){
                $('#iframeheaders #iframetab' + iframeId).removeClass('hidden');
            }else{
                let iframetabs = $('#alliframelist #iframepopup'+iframefileId);
                if(iframetabs.hasClass('fall-down')){
                    iframetabs.addClass('minimized');
                    iframetabs.removeClass('fall-down');
                }else{
                    iframetabs.removeClass('hidden');
                    iframetabs.removeClass('minimized');
                    if(!iframetabs.hasClass('fall-down')){
                       iframetabs.addClass('fall-down');

                    }
                }
            }

        });
        
        let isHoveringPopup = false;
        
        $(document).on('mouseenter', '#iframeheaders .iframemainheadericon', function() {
            var iframeId = $(this).data('iframe-id');
            var iframefileId = $(this).data('iframefile-id');
            var popupcount = $(this).data('popup-count');
            if(popupcount >1){
                $('#iframeheaders #iframetab' + iframeId).removeClass('hidden');
            }
        });
         $(document).on('mouseleave', '#iframeheaders .iframemainheadericon', function() {
            var iframeId = $(this).data('iframe-id');
            var iframefileId = $(this).data('iframefile-id');
            var popupcount = $(this).data('popup-count');

            if(popupcount >1  && isHoveringPopup!=true){
                $('#iframeheaders #iframetab' + iframeId).addClass('hidden');
            }
        });
        
        // Handle hover on the popup element
        $(document).on('mouseenter', '#iframeheaders .parentiframe', function() {
            isHoveringPopup = true;
            //console.log(isHoveringPopup);
        });
    
        $(document).on('mouseleave', '#iframeheaders .parentiframe', function() {
            isHoveringPopup = false;
            // Hide the popup if the mouse leaves the popup element and is not hovering the main header icon
            let iframe = $(this).find('.iframemainheadericon');
            let iframetab = $(this).data('iframe-id');
            $('#iframeheaders #iframetab'+iframetab).addClass('hidden');
        });

        /// click iframe icon 
         $(document).on('click', '#iframeheaders .iframemainheaderpopup', function(e) {
            e.preventDefault();
            var iframeId = $(this).data('iframe-id');
            var iframefileId = $(this).data('iframefile-id');
            console.log(iframefileId);
            //var popupcount = $(this).data('popup-count');
           
                $('#alliframelist #iframepopup'+iframefileId).removeClass('hidden');
                $('#alliframelist #iframepopup'+iframefileId).removeClass('minimized');
                $('#alliframelist #iframepopup'+iframefileId).addClass('fall-down');
                $('#iframeheaders #iframetab'+iframeId).addClass('hidden');
                if(!$('#alliframelist #iframepopup'+iframefileId).hasClass('show')){
                    $('#alliframelist #iframepopup'+iframefileId).addClass('show');

                }
                

        });

        /// animate function 
        function animateIcon(icon, originalIcon, callback) {
            const $originalIcon = $(originalIcon);
            const $toolbar = $('#iframeheaders');
            const rect = $originalIcon[0].getBoundingClientRect();
            const toolbarRect = $toolbar[0].getBoundingClientRect();
            const toolbarCenterX = toolbarRect.left + (toolbarRect.width / 2) - (rect.width / 2);
            const toolbarCenterY = toolbarRect.top + (toolbarRect.height / 2) - (rect.height / 2);

            const moveX = toolbarCenterX - rect.left;
            const moveY = toolbarCenterY - rect.top;

            const $clone = $originalIcon.clone();
            $clone.css({
                position: 'fixed',
                left: `${rect.left}px`,
                top: `${rect.top}px`,
                width: `${rect.width}px`,
                height: `${rect.height}px`,
                'z-index': 9999,
                '--move-x': `${moveX}px`,
                '--move-y': `${moveY}px`
            });
            $clone.addClass('moving-to-top');
            $('body').append($clone);

            $clone.on('animationend', function() {
                $clone.remove();
                // $toolbar.append(icon);
                animateIconToCenter(icon);
                if (callback) callback();
            });
        }

        function animateIconToCenter(icon) {
            const $icon = $(icon);
            $icon.css('opacity', 0);
            setTimeout(() => {
                $icon.css({
                    transition: 'opacity 0.5s, transform 0.5s',
                    opacity: 1,
                    transform: 'translateY(0)'
                });
            }, 10);
        }

      
          /// Upload files 
          $(document).on('click', '.context-menulist .uploadFiles', function (e) {
                e.preventDefault();
                $('#popupuploadfiles').removeClass('hidden');
          });
          $('#close-popup').on('click',function(e){
            e.preventDefault();
                $('#popupuploadfiles').addClass('hidden');
          });

       
       function uploadFiles(){
         
       }
       function createFolderFunction(){
            $.ajax({
                url: createFolderRoute,
                method: 'GET',
                data: {parentFolder: path},
                success: function (response) {
                    if(response.status){
                        toastr.success(response.message);
                        
                    }else{
                        toastr.error(response.message);
                    }
                    desktoplightapp();
                    showapathdetail(path);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
       }
       function createFileFunction(filetype){
        $.ajax({
            url: createFileRoute,
            method: 'GET',
            data: {destination: path,filetype:filetype},
            success: function (response) {
                if(response.status){
                    toastr.success(response.message);
                    
                }else{
                    toastr.error(response.message);
                }
                desktoplightapp();
                showapathdetail(path);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
       }
      openiframe();
        function openiframe(data){
                $.ajax({
                url: openIframeRoute,
                method: 'GET',
                data: data,
                success: function (response) {
                    // Update the app list container with the updated list
                        if(response.status){
                        $('#alliframelist').html(response.html);
                        $('#sortable-apps').html(response.html2);
                        if(response.filekey!=''){
                        $('#alliframelist #'+response.filekey).removeClass('hidden');
                        $('#alliframelist #'+response.filekey).addClass('show');
                        }
                    }else{
                        toastr.error(response.message);
                    }
                    

                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        
        function closeiframe(appkey,filekey,fileid,filetype){
               $('#alliframelist #iframepopup'+fileid).removeClass('hidden');
                $.ajax({
                url: closeIframeRoute,
                method: 'GET',
                data: {appkey:appkey,filekey:filekey,filetype:filetype},
                success: function (response) {
                    // Update the app list container with the updated list
                    $('#alliframelist').html(response.html);
                    $('#sortable-apps').html(response.html2);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        
       function copyFunction(filepath,type,filetype,filekey){
            $.ajax({
            url: copyRoute,
            method: 'GET',
            data: {filepath:filepath,type:type,filekey:filekey,filetype:filetype},
            success: function (response) {
                if(response.status){
                    toastr.success(response.message);
                    $('.pastefileButton').removeClass('hidden');
                }else{
                    toastr.error(response.message);
                }
                desktoplightapp();
                showapathdetail(path);

            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
         
       }
       function renameFunction(filekey,filetype,name){
            $.ajax({
            url: renameroute,
            method: 'GET',
            data: {filekey:filekey,filetype:filetype,name:name},
            success: function (response) {
                if(response.status){
                    toastr.success(response.message);
                    
                }else{
                    toastr.error(response.message);
                }
                desktoplightapp();
                showapathdetail(path);

            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
       }

       function shareFunction(){
         
       }
       function deleteFunction(filekey,filetype){
            $.ajax({
            url: deleteRoute,
            method: 'GET',
            data: {filekey:filekey,filetype:filetype},
            success: function (response) {
                if(response.status){
                    toastr.success(response.message);
                    
                }else{
                    toastr.error(response.message);
                }
                desktoplightapp();
                showapathdetail(path);

            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
            });
       }
       function sortFunction(){
         
       }
       function pasteFunction(filepath){
            $.ajax({
            url: pasteRoute,
            method: 'GET',
            data: {path:filepath},
            success: function (response) {
                if(response.status){
                    toastr.success(response.message);
                     $('.pastefileButton').addClass('hidden');
                }else{
                    toastr.error(response.message);
                }
                desktoplightapp();
                showapathdetail(path);

            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
       }
      


       /// end file functions 


       ///upload code 
       $(document).ready(function() {
        $('#dropzone').on('click', function() {
            $('#file-input').click();
        });

        $('#file-input').on('change', function(e) {
            handleFiles(e.target.files);
        });

        $('#dropzone').on('dragover', function(e) {
            e.preventDefault();
            $(this).addClass('bg-gray-200');
        });

        $('#dropzone').on('dragleave', function(e) {
            e.preventDefault();
            $(this).removeClass('bg-gray-200');
        });

        $('#dropzone').on('drop', function(e) {
            e.preventDefault();
            $(this).removeClass('bg-gray-200');
            handleFiles(e.originalEvent.dataTransfer.files);
        });

        function handleFiles(files) {
            if (files.length > 0) {
                $('#file-list-container').removeClass('hidden');
            }
            $('#file-list').empty();
            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                let fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                let fileRow = $('<tr class="bg-gray-50"></tr>');
                fileRow.append('<td class="py-2 px-4">' + file.name + '</td>');
                fileRow.append('<td class="py-2 px-4">' + fileSize + '</td>');
                let progressBarContainer = $('<td class="py-2 px-4"></td>');
                let progressBar = $('<div class="w-full bg-gray-200 rounded-full h-2.5 relative"><div class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div><i class="ri-check-line text-green-600 absolute right-0 top-0 hidden"></i></div>');
                progressBarContainer.append(progressBar);
                fileRow.append(progressBarContainer);
                $('#file-list').append(fileRow);

                uploadFile(file, progressBar);
            }
        }

        function uploadFile(file, progressBar) {
            let formData = new FormData();
            formData.append('files[]', file);

            $.ajax({
                url: uploadRoute,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'Upload-Directory': path,
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Specify the directory name here
                },
                xhr: function() {
                    let xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            let percentComplete = (e.loaded / e.total) * 100;
                            progressBar.find('div').css('width', percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    progressBar.find('div').css('background-color', 'green');
                    progressBar.find('i').removeClass('hidden');
                    desktoplightapp();
                    showapathdetail(path);
                },
                error: function(error) {
                    console.error('Error uploading file:', error);
                }
            });
        }
    });

       // upload code end


     


