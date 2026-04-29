@extends('layouts.app')
@section('content')
<br>
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-lg">

            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Send Email</h4>
            </div>

            <div class="card-body">
                <form action="/send-email" method="POST" enctype="multipart/form-data">
                    @csrf <div class="mb-3">
                        <label class="form-label fw-bold">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="example@gmail.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Subject</label>
                        <input type="text" name="subject" class="form-control" placeholder="Enter Subject" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Message</label>
                        <textarea name="message" class="form-control" rows="5" placeholder="Write your message here..." required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Attachment (Optional)</label>
                        <input type="file" name="attachment" class="form-control">
                        <!-- <small class="text-muted">Allowed types: pdf, jpg, png, doc (Max: 2MB)</small> -->
                    </div>

                    <button type="submit" class="btn btn-success w-100 shadow-sm">
                        <i class="bi bi-send me-2"></i>Send Email
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection