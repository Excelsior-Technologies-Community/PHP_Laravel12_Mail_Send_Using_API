@extends('layouts.app')
@section('content')
<br>
<div class="row justify-content-center">
    <div class="col-md-6">

        <!-- Card Container for Form -->
        <div class="card shadow-lg">

            <!-- Card Header -->
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Send Email</h4>
            </div>

            <!-- Card Body: Form Starts -->
            <div class="card-body">
                <!-- Form POSTs to send email route -->
                <form action="/send-email" method="POST">
                    @csrf <!-- CSRF token for security -->

                    <!-- Recipient Email Input -->
                    <div class="mb-3">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <!-- Email Subject Input -->
                    <div class="mb-3">
                        <label>Subject</label>
                        <input type="text" name="subject" class="form-control" required>
                    </div>

                    <!-- Email Message Input -->
                    <div class="mb-3">
                        <label>Message</label>
                        <textarea name="message" class="form-control" rows="5" required></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success w-100">
                        Send Email
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
