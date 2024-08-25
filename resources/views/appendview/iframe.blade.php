@if(!empty($iframeapp))
    @foreach($iframeapp as $iframekey=>$iframeval)
    
        @foreach($iframeval as $iframedetail)
        <?php //print_r($iframedetail['filetype']);die;?>
               <!--Iframe popup-->
                <div id="iframepopup{{ $iframedetail['filetype'].$iframedetail['filekey'] }}" data-app-id="iframepopup{{$iframedetail['filetype'].$iframedetail['filekey'] }}" class="draggableelement box popupiframe fixed inset-0 bg-black-900 bg-opacity-50 flex items-center justify-center rounded-lg hidden">
                        <div class="draggable bg-opacity-70  shadow-lg w-full h-full relative">
                        <div class="flex justify-between items-center p-1 pr-2 border-b bg-c-gray-gradient">
                            <span class="text-lg flex font-semibold">
                            <img class="w-5 h-5 mt-1" src="{{ checkIconExist($iframedetail['appicon'],'app') }}"/>
                            <h2 class="text-white ml-2 font-thin">
                                {{$iframedetail['appname'] }}
                            </h2>
                            </span>
                            <div class="flex space-x-1">
                            <a href="#"  class="minimizeiframe-btn" data-iframe-id="{{$iframedetail['filetype'].$iframedetail['filekey'] }}"><img src="{{ asset($constants['IMAGEFILEPATH'].'minimize'.$constants['ICONEXTENSION'])}}"/></a>
                            <a href="#" class="maximizeiframe-btn" data-iframe-id="{{$iframedetail['filetype'].$iframedetail['filekey'] }}"><img src="{{ asset($constants['IMAGEFILEPATH'].'maximize'.$constants['ICONEXTENSION'])}}"/></a>
                            <a href="#" class="closeiframe-btn" data-filekey="{{$iframedetail['filekey'] }}" data-iframe-id = "{{$iframedetail['filetype'].$iframedetail['filekey'] }}" data-appkey="{{ $iframedetail['appkey'] }}" data-filetype="{{ $iframedetail['filetype'] }}" ><img src="{{ asset($constants['IMAGEFILEPATH'].'close'.$constants['ICONEXTENSION'])}}"/></a>
                            </div>
                        </div>
                        <!--comment section-->
                        
                            <!--chat list-->
                            
                            <!--Add comment-->
                            <!--comment section-->

                        <!--Iframe-->
                        <iframe id="iframe{{ $iframedetail['filetype'].$iframedetail['filekey'] }}" src="{{ $iframedetail['iframeurl'] }}" class="w-full h-full frame"></iframe>
                        <!--chat button-->

                          <!--chat button-->
        
                        
                        </div>
                    </div>
                <!-- iframe close -->
        @endforeach
     @endforeach
@endif
