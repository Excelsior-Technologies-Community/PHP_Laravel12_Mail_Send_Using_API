@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

            <!-- Card Container for Email Details -->
            <div class="card border-0 shadow-lg rounded-4">

                <!-- Card Header with Gradient Background -->
                <div class="card-header text-white text-center py-4 rounded-top-4" 
                     style="background: linear-gradient(90deg, #4e73df, #1cc88a);">
                    <h3 class="mb-0">
                        <i class="bi bi-envelope-fill me-2"></i>Email Details
                    </h3>
                </div>

                <!-- Card Body -->
                <div class="card-body p-4">

                    <!-- Recipient Email Section -->
                    <div class="mb-4">
                        <h6 class="text-muted fw-bold">Recipient Email</h6>
                        <div class="p-3 border rounded bg-light text-break">
                            {{ $mail->email }}
                        </div>
                    </div>

                    <!-- Email Subject Section -->
                    <div class="mb-4">
                        <h6 class="text-muted fw-bold">Subject</h6>
                        <div class="p-3 border rounded bg-light text-break">
                            {{ $mail->subject }}
                        </div>
                    </div>

                    <!-- Email Message Section -->
                    <div class="mb-4">
                        <h6 class="text-muted fw-bold">Message</h6>
                        <!-- Preserve line breaks using pre-wrap -->
                        <div class="p-3 border rounded bg-light" style="white-space: pre-wrap;">
                            {{ $mail->message }}
                        </div>
                    </div>

                    <!-- Status & Created At Info Boxes -->
                    <div class="row mb-4 g-3 text-center">

                        <!-- Status Box -->
                        <div class="col-md-6">
                            <div class="p-3 border rounded shadow-sm bg-white">
                                <h6 class="text-muted fw-bold mb-2">
                                    <i class="bi bi-toggle-on me-2"></i>Status
                                </h6>
                                <!-- Show Active/Inactive badge -->
                                @if($mail->status == 1)
                                    <span class="badge bg-success px-3 py-2 fs-6">Active</span>
                                @else
                                    <span class="badge bg-danger px-3 py-2 fs-6">Inactive</span>
                                @endif

                                <!-- Show Deleted badge if soft deleted -->
                                @if($mail->deleted_at)
                                    <span class="badge bg-warning text-dark px-3 py-2 fs-6 ms-1">Deleted</span>
                                @endif
                            </div>
                        </div>

                        <!-- Created At Box -->
                        <div class="col-md-6">
                            <div class="p-3 border rounded shadow-sm bg-white">
                                <h6 class="text-muted fw-bold mb-2">
                                    <i class="bi bi-calendar-check me-2"></i>Created At
                                </h6>
                                <div>{{ $mail->created_at->format('d-m-Y H:i A') }}</div>
                            </div>
                        </div>

                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-center flex-wrap gap-3">
                        <!-- Back to Mail List -->
                        <a href="{{ url('/mail') }}" class="btn btn-secondary btn-lg shadow-sm">Back</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons for icons like envelope and calendar -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
