<?php 

function base64UrlEncode($data) {
    // Standard base64 encode
    $base64 = base64_encode($data);
    // URL-safe base64 encode
    $base64Url = str_replace(['+', '/', '='], ['-', '_', ''], $base64);
    return $base64Url;
}

function base64UrlDecode($data) {
    // URL-safe base64 decode
    $base64 = str_replace(['-', '_'], ['+', '/'], $data);
    // Standard base64 decode
    $decoded = base64_decode($base64);
    return $decoded;
}
function checkIconExist($filePath, $type) {
    $fileIconPath = config('constants.FILEICONPATH');
    $appIconPath = config('constants.APPFILEPATH');
    $iconExtension = config('constants.ICONEXTENSION');
    $otherIconPath = config('constants.OTHERFILEPATH');
    $defaultIcon = asset($otherIconPath . 'default.svg');
    if (!empty($filePath) && !empty($type) && in_array($type, ['file', 'app', 'folder','menu'])) {
        switch ($type) {
            case 'app':
                $fileIconDefault = asset($appIconPath . 'defaultapp.svg');
                $fileIconRelativePath = $appIconPath . $filePath;
                break;

            case 'folder':
                $fileIconDefault = asset($fileIconPath . 'defaultfolder.png');
                $fileIconRelativePath = $fileIconPath . $filePath . $iconExtension;
                break;
            case 'menu':
                $fileIconDefault = asset($fileIconPath . 'defaultfolder.png');
                $fileIconRelativePath = $fileIconPath . $filePath . $iconExtension;
            break;

            default:
                $fileIconRelativePath = $fileIconPath . $filePath . $iconExtension;
        }

        $fileIconFullPath = base_path($fileIconRelativePath);
        if (file_exists($fileIconFullPath)) {
            return asset($fileIconRelativePath);
        } else {
            if ($type == 'file' || $type == 'folder') {
                $fileIconPngRelativePath = $fileIconPath . $filePath . '.png';
                $fileIconPngFullPath = base_path($fileIconPngRelativePath);

                if (file_exists($fileIconPngFullPath)) {
                    return asset($fileIconPngRelativePath);
                }
            }else if($type == 'menu'){
                $fileIconPngRelativePath = $fileIconPath . $filePath . '.png';
                $fileIconPngFullPath = base_path($fileIconPngRelativePath);

                if (file_exists($fileIconPngFullPath)) {
                    return asset($fileIconPngRelativePath);
                }else{
                    return false;
                }
            }else{
                return $fileIconDefault;
            }
            
        }
    }
    if($type == 'menu'){
        return false;
    }
    return $defaultIcon;
}


function checkFileGroup($ext){
        $ExtsDoc = array("doc", "docm", "docx", "dot", "dotm", "dotx", "epub", "fodt", "ott", "htm", "html", "mht", "odt", "pdf", "rtf", "txt", "djvu", "xps");
        $ExtsPre = array("fodp", "odp", "pot", "potm", "potx", "pps", "ppsm", "ppsx", "ppt", "pptm", "pptx", "otp");
        $ExtsSheet = array("xls", "xlsx", "xltx", "ods", "ots", "csv", "xlt", "xltm", "fods");
        $ExtsImage = array("jpg", "jpeg", "png", "gif", "bmp", "webp", "tiff", "tif", "ico", "svg", "heif", "heic", "raw", "nef", "cr2", "orf", "dng");
        $ExtsVideo = array("mp4", "mkv", "avi", "mov", "wmv", "flv", "webm", "mpg", "mpeg", "ogv", "3gp", "3g2", "m4v", "rm", "rmvb", "ts", "vob", "m2ts", "asf", "mts");       
        $ExtsAudio = array("mp3", "wav", "aac", "flac", "ogg", "wma", "m4a", "alac", "aiff", "au", "mid", "midi", "opus", "ra", "ram", "ape", "dsd");
        if (in_array($ext,$ExtsDoc)) {
            return "editor";
        } elseif (in_array($ext,$ExtsPre)) {
            return "editor";
        } elseif (in_array($ext,$ExtsSheet)) {
            return "editor";
        }elseif (in_array($ext,$ExtsImage)) {
            return "image";
         }elseif (in_array($ext,$ExtsVideo)) {
            return "video";
         }elseif (in_array($ext,$ExtsAudio)) {
            return "audio";
         } else {
            return "other";
        }
    
}

function checkLightApp($ext){
    $ExtsDoc = array("doc", "docm", "docx", "dot", "dotm", "dotx", "epub", "fodt", "ott", "htm", "html", "mht", "odt", "pdf", "rtf", "txt", "djvu", "xps");
    $ExtsPre = array("fodp", "odp", "pot", "potm", "potx", "pps", "ppsm", "ppsx", "ppt", "pptm", "pptx", "otp");
    $ExtsSheet = array("xls", "xlsx", "xltx", "ods", "ots", "csv", "xlt", "xltm", "fods");
    
    if (in_array($ext,$ExtsDoc)) {
        return "Docx";
    } elseif (in_array($ext,$ExtsPre)) {
        return "EXCEL";
    } elseif (in_array($ext,$ExtsSheet)) {
        return "PPT";
    }else {
        return "DotsViewer";
    }

}



?>