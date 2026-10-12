@extends('layouts.app')

@section('title', 'Student Management')

@section('content')
    <section class="dashboard-heading">
        <div>
            <p class="eyebrow">OVERVIEW</p>
            <h1>Student Management</h1>
            <p class="page-subtitle">Manage your student records in one place.</p>
        </div>
        <a class="btn btn-primary" href="{{ route('students.create') }}">
            <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M10 4v12M4 10h12" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            Add Student
        </a>
    </section>

    <section class="stats-grid" aria-label="Student statistics">
        <article class="stat-card">
            <span class="stat-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none"><path d="M16 20v-1.7c0-1.8-1.6-3.3-3.5-3.3h-5C5.6 15 4 16.5 4 18.3V20M10 11a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7ZM16 4.2a3.5 3.5 0 0 1 0 6.8M17 15h1.5c1.9 0 3.5 1.5 3.5 3.3V20" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <div>
                <p class="stat-label">Total students</p>
                <p class="stat-value">{{ $students->count() }}</p>
                <p class="stat-caption">Records in your directory</p>
            </div>
        </article>
    </section>

    <section class="content-card">
        <div class="card-heading">
            <div>
                <h2>All students</h2>
                <p class="card-description">A complete list of your student records.</p>
            </div>
            <span class="record-count">{{ $students->count() }} {{ \Illuminate\Support\Str::plural('record', $students->count()) }}</span>
        </div>

        @if ($students->isEmpty())
            <div class="empty-state">
                <span class="empty-icon" aria-hidden="true">
                    <svg viewBox="0 0 48 48" fill="none"><circle cx="24" cy="24" r="21" fill="currentColor" opacity=".08"/><path d="M24 15v18M15 24h18" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>
                </span>
                <h3>No students yet</h3>
                <p>Your student directory is ready. Add your first student to get started.</p>
                <a class="btn btn-primary" href="{{ route('students.create') }}">
                    <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M10 4v12M4 10h12" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                    Add your first student
                </a>
            </div>
        @else
            <div class="table-container">
                <table class="student-table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Course</th>
                            <th scope="col" class="actions-heading">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td><span class="student-id">#{{ $student->id }}</span></td>
                                <td>
                                    <div class="student-name-cell">
                                        <span class="avatar">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($student->name, 0, 1)) }}</span>
                                        <span class="student-name">{{ $student->name }}</span>
                                    </div>
                                </td>
                                <td><a class="student-email" href="mailto:{{ $student->email }}">{{ $student->email }}</a></td>
                                <td><span class="course-pill">{{ $student->course }}</span></td>
                                <td>
                                    <div class="table-actions">
                                        <a class="btn btn-outline btn-small" href="{{ route('students.edit', $student) }}" aria-label="Edit {{ $student->name }}">
                                            <svg viewBox="0 0 20 20" aria-hidden="true"><path d="m13.8 3.7 2.5 2.5M4 16l3.1-.6L16 6.5 13.5 4 4.6 12.9 4 16Z" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('students.destroy', $student) }}" method="POST" data-confirm-delete>
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-small" type="submit" aria-label="Delete {{ $student->name }}">
                                                <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M4.5 6h11M8 6V4.5h4V6m2.5 0-.6 9.2a1.3 1.3 0 0 1-1.3 1.2H7.4a1.3 1.3 0 0 1-1.3-1.2L5.5 6m3 3v4m3-4v4" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection