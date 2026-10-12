<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if (session()->has('success'))
        @php
            $successAlert = match (session('success_type')) {
                'created' => [
                    'title' => 'Student Added!',
                    'text' => 'The student has been added successfully.',
                ],
                'updated' => [
                    'title' => 'Student Updated!',
                    'text' => 'The student details have been updated successfully.',
                ],
                'deleted' => [
                    'title' => 'Student Deleted!',
                    'text' => 'The student has been deleted successfully.',
                ],
                default => [
                    'title' => 'Success',
                    'text' => session('success'),
                ],
            };
        @endphp

        Swal.fire({
            title: @json($successAlert['title']),
            text: @json($successAlert['text']),
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif

    @if ($errors->any())
        Swal.fire({
            title: 'Validation Error',
            text: @json($errors->first()),
            icon: 'error',
            confirmButtonText: 'OK'
        });
    @endif

    document.addEventListener('submit', function (event) {
        const form = event.target.closest('form[data-confirm-delete]');

        if (!form) {
            return;
        }

        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: 'This student record will be deleted.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            focusCancel: true
        }).then(function (result) {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
