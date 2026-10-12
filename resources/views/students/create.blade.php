
@extends('layouts.app')

@section('title', 'Add Student')

@section('content')
    <div class="form-page">
        <a class="back-link" href="{{ route('students.index') }}">
            <svg viewBox="0 0 20 20" aria-hidden="true"><path d="m12.5 4.5-5.5 5.5 5.5 5.5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Back to students
        </a>

        <section class="form-card">
            <div class="form-card-heading">
                <span class="form-heading-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM4 20v-1.5A4.5 4.5 0 0 1 8.5 14h7a4.5 4.5 0 0 1 4.5 4.5V20M19 8v6m-3-3h6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
                <p class="eyebrow">STUDENT DIRECTORY</p>
                <h1>Add New Student</h1>
                <p class="form-subtitle">Add a student to your directory by filling in their details below.</p>
            </div>

            <form action="{{ route('students.store') }}" method="POST" class="student-form">
                @csrf

                <div class="form-group">
                    <label for="name">Full name <span class="required-mark">*</span></label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Alex Morgan" autocomplete="name" required aria-describedby="name-error">
                    @error('name')
                        <p class="field-error" id="name-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email address <span class="required-mark">*</span></label>
                    <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" autocomplete="email" required aria-describedby="email-error">
                    @error('email')
                        <p class="field-error" id="email-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="course">Course <span class="required-mark">*</span></label>
                    <input class="form-control @error('course') is-invalid @enderror" type="text" id="course" name="course" value="{{ old('course') }}" placeholder="e.g. Computer Science" required aria-describedby="course-error">
                    @error('course')
                        <p class="field-error" id="course-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-actions">
                    <a class="btn btn-secondary" href="{{ route('students.index') }}">Cancel</a>
                    <button class="btn btn-primary" type="submit">
                        <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M10 4v12M4 10h12" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                        Save Student
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection
