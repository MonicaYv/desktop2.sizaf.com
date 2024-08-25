@if(!empty($iframeapp))
@foreach($iframeapp as $iframekey=>$iframeval)
    <div class="relative parentiframe draggable-element">
                <div id="iframeicon{{ $iframeval[0]['filetype'].$iframekey }}" data-popup-count="{{ count($iframeval) }}" data-iframefile-id = "{{ $iframeval[0]['filetype'].$iframeval[0]['filekey'] }}" data-iframe-id = "{{ $iframeval[0]['filetype'].$iframekey }}" class="iframemainheadericon flex items-center justify-center text-white cursor-pointer">
                    <img class="app-icon" id ="iframeiconimage{{ $iframeval[0]['filetype'].$iframekey }}" data-app-id ="iframeiconimage{{ $iframeval[0]['filetype'].$iframekey }}" src="{{ checkIconExist($iframeval[0]['appicon'],'app') }}" >
                </div>
            @if(count($iframeval)>1)
                <div class="hidden iframetabselement fixed top-12 left-1/2 transform -translate-x-1/2" id="iframetab{{ $iframeval[0]['filetype'].$iframekey }}">
                    <div class="flex flex-row-reverse space-x-2 space-x-reverse">
                    
                    
                    @foreach($iframeval as $iframefile)
        
                            <div class="popup bg-white p-2 rounded shadow-md iframemainheaderpopup" id="iframefilepopupdet{{ $iframefile['filetype'].$iframefile['filekey'] }}"  data-popup-count="{{ count($iframeval) }}" data-iframefile-id = "{{ $iframefile['filetype'].$iframefile['filekey'] }}" data-iframe-id = "{{ $iframefile['filetype'].$iframekey }}" >
                                <div class="flex justify-between items-center -mt-2 mb-2">
                                    <div class="overflow-hidden scrollbar-hidden scroll-container max-w-full">
                                        <div class="whitespace-no-wrap mt-2 flex text-black scroll-content">
                                            <img class="mr-2" src="{{ checkIconExist($iframefile['appicon'],'app') }}"><span>{{ $iframefile['filename'] }}</span>
                                        </div>
                                    </div>
                                    <button class="iframefilepopupclosebtn -mr-2 -mt-2 text-gray-500 hover:text-gray-700" data-filekey="{{ $iframefile['filekey'] }}" data-iframefile-id = "{{ $iframefile['filetype'].$iframefile['filekey'] }}" data-appkey="{{ $iframekey }}" data-filetype="{{ $iframefile['filetype'] }}">
                                        <i class="ri-close-line"></i>
                                    </button>
                                </div>
                            </div>
        @endforeach
       
                    </div>
                </div>
    @endif
            </div>
     @endforeach
     @endif
