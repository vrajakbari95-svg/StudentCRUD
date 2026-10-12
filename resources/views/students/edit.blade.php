@extends('layouts.app')

@section('title', 'Edit Student')

@section('content')
    <div class="form-page">
        <a class="back-link" href="{{ route('students.index') }}">
            <svg viewBox="0 0 20 20" aria-hidden="true"><path d="m12.5 4.5-5.5 5.5 5.5 5.5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Back to students
        </a>

        <section class="form-card">
            <div class="form-card-heading">
                <span class="form-heading-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none"><path d="m14.5 5.5 4 4M5 19l4.6-.9L19.5 8.2l-4-4L5.9 13.8 5 19Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
                <p class="eyebrow">STUDENT DIRECTORY</p>
                <h1>Edit Student Details</h1>
                <p class="form-subtitle">Update the information for {{ $student->name }}.</p>
            </div>

            <form action="{{ route('students.update', $student) }}" method="POST" class="student-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Full name <span class="required-mark">*</span></label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name', $student->name) }}" placeholder="e.g. Alex Morgan" autocomplete="name" required aria-describedby="name-error">
                    @error('name')
                        <p class="field-error" id="name-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email address <span class="required-mark">*</span></label>
                    <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email', $student->email) }}" placeholder="name@example.com" autocomplete="email" required aria-describedby="email-error">
                    @error('email')
                        <p class="field-error" id="email-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="course">Course <span class="required-mark">*</span></label>
                    <input class="form-control @error('course') is-invalid @enderror" type="text" id="course" name="course" value="{{ old('course', $student->course) }}" placeholder="e.g. Computer Science" required aria-describedby="course-error">
                    @error('course')
                        <p class="field-error" id="course-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-actions">
                    <a class="btn btn-secondary" href="{{ route('students.index') }}">Cancel</a>
                    <button class="btn btn-primary" type="submit">
                        <svg viewBox="0 0 20 20" aria-hidden="true"><path d="m4 10 4 4 8-8" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Update Student
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection