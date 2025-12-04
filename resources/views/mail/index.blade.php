@extends('layouts.app')

@section('content')
<div class="card shadow-lg">
    <!-- Card Header: Title + Send Email Button -->
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Mail Logs</h4>
        <!-- Button to open Send Email Form -->
        <a href="{{ url('/email') }}" class="btn btn-success btn-sm mb-3">
            Send Email
        </a>
    </div>

    <!-- Card Body -->
    <div class="card-body">

        <!-- Display Success Message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Table: List of Mail Logs -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            @forelse($mails as $mail)
                <tr>
                    <td>{{ $mail->id }}</td>
                    <td>{{ $mail->email }}</td>
                    <td>{{ $mail->subject }}</td>
                    <td>
                        <!-- Status Badge -->
                        @if($mail->status == 1)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $mail->created_at->format('d-m-Y') }}</td>
                    <td>
                        <!-- View Mail Details -->
                        <a href="{{ url('/mail/view/'.$mail->id) }}" class="btn btn-sm btn-primary">View</a>
                        <!-- Soft Delete Mail -->
                        <a href="{{ url('/mail/delete/'.$mail->id) }}" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Are you sure you want to delete this mail?');">
                            Delete
                        </a>
                    </td>
                </tr>
            @empty
                <!-- Show if no mails -->
                <tr>
                    <td colspan="6" class="text-center">No Email Logs Found</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $mails->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Optional: Modal for Sending Email (if needed in future) -->
<div class="modal fade" id="sendEmailModal" tabindex="-1" aria-labelledby="sendEmailModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Form to send email -->
      <form action="{{ url('/mail/send') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="sendEmailModalLabel">Send Email</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <!-- Recipient Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Recipient Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <!-- Subject -->
            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject" required>
            </div>
            <!-- Message -->
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <!-- Modal Buttons -->
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Send Email</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

