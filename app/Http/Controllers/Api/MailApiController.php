<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\TestMail;
use App\Models\MailLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailApiController extends Controller
{
    /**
     * Send an email and save log - API
     */
    public function send(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'email'   => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        // Save log
        $log = MailLog::create([
            'email'      => $validated['email'],
            'subject'    => $validated['subject'],
            'message'    => $validated['message'],
            'created_by' => 1,
            'status'     => 1,
        ]);

        // Email details for Mailable
        $details = [
            'title' => $validated['subject'],
            'body'  => $validated['message'],
        ];

        // Send Email
        Mail::to($validated['email'])->send(new TestMail($details));

        return response()->json([
            'success' => true,
            'message' => 'Email sent successfully!',
            'data'    => $log
        ], 200);
    }

    /**
     * List all active emails (pagination)
     */
    public function list()
    {
        $mails = MailLog::where('status', 1)
                        ->orderBy('id', 'ASC')
                        ->paginate(10);

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

        // Toggle status
        $mail->status = $mail->status == 1 ? 0 : 1;
        $mail->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated!',
            'status'  => $mail->status
        ], 200);
    }
}
