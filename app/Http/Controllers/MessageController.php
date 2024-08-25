<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Group;
use App\Models\Roles;
use App\Models\User;
use App\Models\CommentReciver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Jobs\CommentMailSend;

class MessageController extends Controller
{
    public function getUsers()
    {
     
        $users = User::all();
        $groups = Group::all();
        $roles = Roles::all();
        return response()->json([
            'users' => $users,
            'groups' => $groups,
            'roles' => $roles,
        ]);
    }

    public function saveCommentOrReply(Request $request)
    {
        // dd($request->all());exit;
        try {
            // fetching file key
            $fileKey = Session('iframeapp');
            $fileKey = base64UrlDecode($fileKey[0]['files'][0]['filekey']);

            $group_id = $request->receiver_type == 'Group' ? $request->input('receiver_id') : null;
            $role_id = $request->receiver_type == 'Role' ? $request->input('receiver_id') : null;
            
            // Adjust the validation rules
            $request->validate([
                'user_id' => 'required|integer',
                'receiver_id' => 'nullable|string',
                'receiver_type' => 'nullable|string',
                'message' => 'required|string',
                'fileID' => 'nullable|string',
                'parent_message_id' => 'nullable|integer',
            ]);
            Log::info('Request Data:', $request->all());
            $comment = new Comment();
            $comment->sender = $request->input('user_id');
            $comment->message = $request->input('message');
            $comment->file_id = $fileKey;
            // $comment->file_id = $request->input('fileID') ?: null;
            // $comment->receiver_id = $request->input('receiver_id') ?: null;
            $comment->receiver_type = $request->input('receiver_type') ?: null;
            
            $comment->group_id = $group_id;
            $comment->role_id = $role_id;
    
            if ($request->input('parent_message_id')) {
                $comment->parent = $request->input('parent_message_id');
                $responseMessage = 'Reply saved successfully.';
            } else {
                $responseMessage = 'Comment saved successfully.';
            }
            // dd($comment);exit;
            $comment->save();

            if($request->receiver_type == 'User' && $request->input('receiver_id') != null){
                

                $commentReciver = CommentReciver::create([
                    'receiver_id' => $request->input('receiver_id'),
                    'comment_id' => $comment->id
                ]);

                /*$user = User::find($request->receiver_id);
               $email = $user->email;
              $cmt = $request->message;

                //dd('>>>>>>>>>>');
                Mail::send('mail-templates.Comment', compact('user','cmt'), function ($message) use ($email) {    
            $message->to($email);
            $message->subject("You are Tagged in a Comment.");
            //CommentMailSend::dispatch($user, $email,$cmt);
        });*/
                 /*CommentMailSend::dispatch($request->input('receiver_id'),$request->input('message'));*/


            } else if($request->receiver_type == 'Role'){
                //get list of role according to id 
                $list = User::where('roleID', $request->input('receiver_id'))->get();
                foreach ($list as $key) {
                    $commentReciver = CommentReciver::create([
                        'receiver_id' => $key->id,
                        'comment_id' => $comment->id
                    ]);

             /*$user = User::find($key->id);
               $email = $user->email;
              $cmt = $request->message;

                //dd('>>>>>>>>>>');
                Mail::send('mail-templates.Comment', compact('user','cmt'), function ($message) use ($email) {    
            $message->to($email);
            $message->subject("You are Tagged in a Comment.");
        });*/
                }

            } else if($request->receiver_type == 'Group'){
                // dd(Auth::user()->name, $comment);
                //get list of role according to id 
                $list = User::where('groupID', $request->input('receiver_id'))->get();
                foreach ($list as $key) {
                    $commentReciver = CommentReciver::create([
                        'receiver_id' => $key->id,
                        'comment_id' => $comment->id
                    ]);
                 //CommentMailSend::dispatch($key->id ,$request->input('message'));
                     /*$user = User::find($key->id);
               $email = $user->email;
              $cmt = $request->message;

                //dd('>>>>>>>>>>');
                Mail::send('mail-templates.Comment', compact('user','cmt'), function ($message) use ($email) {    
            $message->to($email);
            $message->subject("You are Tagged in a Comment.");
        });*/

                }

            }

            //sending mail 
            $cmt = $request->message;
            $auth = Auth::user()->name;

            foreach ($request->user_array as $el) {
                if ($el['type'] == 'User') {
                    $user = User::find($el['id']);
                    $email = $user->email;

                    /*Mail::send('mail-templates.Comment', compact('user', 'cmt'), function ($message) use ($email) {
                        $message->to($email);
                        $message->subject("You are Tagged in a Comment.");
                    });*/
                    
                    CommentMailSend::dispatch($user, $cmt, $auth);

                    /*dump($email,'user',$el['id']);*/
                }

                if ($el['type'] == 'Role') {
                    $list = User::where('roleID', $el['id'])->get();
                    foreach ($list as $key) {
                        $commentReciver = CommentReciver::create([
                            'receiver_id' => $key->id,
                            'comment_id' => $comment->id
                        ]);

                        $user = User::find($key->id);
                        // $email = $user->email;

                        CommentMailSend::dispatch($user, $cmt, $auth);

                        /*Mail::send('mail-templates.Comment', compact('user', 'cmt'), function ($message) use ($email) {
                            $message->to($email);
                            $message->subject("You are Tagged in a Comment.");
                        });*/
                        /*dump($email,'role',$key->id);*/
                    }
                }

                if ($el['type'] == 'Group') {
                    $list = User::where('groupID', $el['id'])->get();
                    foreach ($list as $key) {
                        $commentReciver = CommentReciver::create([
                            'receiver_id' => $key->id,
                            'comment_id' => $comment->id
                        ]);

                        $user = User::find($key->id);
                        // $email = $user->email;

                        CommentMailSend::dispatch($user, $cmt, $auth);
                        
                        /*Mail::send('mail-templates.Comment', compact('user', 'cmt'), function ($message) use ($email) {
                            $message->to($email);
                            $message->subject("You are Tagged in a Comment.");
                        });*/
                         /*dump($email,'group',$key->id);*/
                    }
                }
            }

    
            return response()->json([
                'success' => true,
                'message' => $responseMessage,
                'comment' => $comment,
            ]);
    
        } catch (\Exception $e) {
            Log::error("Error saving comment or reply: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error saving comment or reply',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function getMessageData()
{

    // fetching file key
    $fileKey = Session('iframeapp');
    $fileKey = count($fileKey) > 0 ? base64UrlDecode($fileKey[0]['files'][0]['filekey']) : null;

    $messages = Comment::where('file_id', $fileKey)->with('user')->with('group')->with('role')->with('commentRecivers.receiver')->get();
    
    return response()->json([
        'messages' => $messages,

    ]);
}



public function destroy(Request $request)
    {
        $message = Comment::find($request->id);
        // $message_2 = CommentReciver::select('comment_id', $request->id);
// dump($message->toArray());
        if ($message) {
            // dd('88');
            // $message_2->delete();
            $message->delete();
            return response()->json(['success' => true, 'message' => 'Message deleted successfully']);
        }

        return response()->json(['success' => true, 'message' => 'Message not found']);
        // return response()->json(['success' => false, 'message' => 'Message not found'], 404);
    }



}
