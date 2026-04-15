<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\TestMail;
use App\Models\MailLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MailApiController extends Controller
{
    /**
     * Send an email and save log - API
     */
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'   => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        // Save log initially
        $log = MailLog::create([
            'email'      => $validated['email'],
            'subject'    => $validated['subject'],
            'message'    => $validated['message'],
            'created_by' => 1,
            'status'     => 1, // default
        ]);

        $details = [
            'title' => $validated['subject'],
            'body'  => $validated['message'],
        ];

        try {
            Mail::to($validated['email'])->send(new TestMail($details));

            $log->status = 1; // Sent
        } catch (\Exception $e) {
            $log->status = 2; // Failed
        }

        $log->save();

        return response()->json([
            'success' => true,
            'message' => 'Email processed',
            'status'  => $log->status,
            'data'    => $log
        ], 200);
    }

    /**
     * List emails with search & filter
     */
    public function list(Request $request)
    {
        $query = MailLog::query();

        // Search
        if ($request->search) {
            $query->where('email', 'like', '%' . $request->search . '%')
                ->orWhere('subject', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->status !== null) {
            $query->where('status', $request->status);
        }

        $mails = $query->orderBy('id', 'ASC')->paginate(10);

        return response()->json([
            'success' => true,
            'data'    => $mails
        ], 200);
    }

    /**
     * View single mail
     */
    public function view($id)
    {
        $mail = MailLog::find($id);

        if (!$mail) {
            return response()->json([
                'success' => false,
                'message' => 'Mail not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $mail
        ], 200);
    }

    /**
     * RESEND FAILED EMAIL (NEW FEATURE)
     */
    public function resend($id)
    {
        $mail = MailLog::find($id);

        if (!$mail) {
            return response()->json([
                'success' => false,
                'message' => 'Mail not found'
            ], 404);
        }

        try {
            $details = [
                'title' => $mail->subject,
                'body'  => $mail->message,
            ];

            Mail::to($mail->email)->send(new TestMail($details));

            $mail->status = 1; // Sent
            $mail->save();

            return response()->json([
                'success' => true,
                'message' => 'Email resent successfully'
            ]);
        } catch (\Exception $e) {
            $mail->status = 2; // Failed again
            $mail->save();

            return response()->json([
                'success' => false,
                'message' => 'Resend failed'
            ]);
        }
    }

    /**
     * Soft delete mail
     */
    public function delete($id)
    {
        $mail = MailLog::find($id);

        if (!$mail) {
            return response()->json([
                'success' => false,
                'message' => 'Mail not found'
            ], 404);
        }

        $mail->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mail deleted successfully!'
        ], 200);
    }

    /**
     * Restore soft deleted mail
     */
    public function restore($id)
    {
        $mail = MailLog::withTrashed()->find($id);

        if (!$mail) {
            return response()->json([
                'success' => false,
                'message' => 'Mail not found'
            ], 404);
        }

        $mail->restore();

        return response()->json([
            'success' => true,
            'message' => 'Mail restored successfully!'
        ], 200);
    }

    /**
     * Force delete (permanent)
     */
    public function forceDelete($id)
    {
        $mail = MailLog::withTrashed()->find($id);

        if (!$mail) {
            return response()->json([
                'success' => false,
                'message' => 'Mail not found'
            ], 404);
        }

        $mail->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Mail permanently deleted!'
        ], 200);
    }

    /**
     * Change mail status (Active/Inactive)
     */
    public function changeStatus($id)
    {
        $mail = MailLog::find($id);

        if (!$mail) {
            return response()->json([
                'success' => false,
                'message' => 'Mail not found'
            ], 404);
        }

        $mail->status = $mail->status == 1 ? 0 : 1;
        $mail->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated!',
            'status'  => $mail->status
        ], 200);
    }
}
