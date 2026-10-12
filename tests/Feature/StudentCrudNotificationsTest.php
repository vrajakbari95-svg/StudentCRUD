<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class StudentCrudNotificationsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('course')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('students');

        parent::tearDown();
    }

    public function test_create_shows_a_one_time_success_notification(): void
    {
        $response = $this->post(route('students.store'), [
            'name' => 'Alex Student',
            'email' => 'alex@example.test',
            'course' => 'Computer Science',
        ]);

        $response->assertRedirect(route('students.index'))
            ->assertSessionHas('success_type', 'created');

        $this->get(route('students.index'))
            ->assertOk()
            ->assertSee('Student Added!')
            ->assertSee('The student has been added successfully.');

        $this->get(route('students.index'))
            ->assertDontSee('Student Added!');

        $this->assertDatabaseHas('students', ['email' => 'alex@example.test']);
    }

    public function test_update_and_delete_use_operation_specific_notifications(): void
    {
        $student = Student::create([
            'name' => 'Alex Student',
            'email' => 'alex@example.test',
            'course' => 'Computer Science',
        ]);

        $this->put(route('students.update', $student), [
            'name' => 'Alex Student',
            'email' => 'alex@example.test',
            'course' => 'Mathematics',
        ])->assertRedirect(route('students.index'))
            ->assertSessionHas('success_type', 'updated');

        $this->get(route('students.index'))
            ->assertSee('Student Updated!')
            ->assertSee('The student details have been updated successfully.');

        $this->delete(route('students.destroy', $student))
            ->assertRedirect(route('students.index'))
            ->assertSessionHas('success_type', 'deleted');

        $this->get(route('students.index'))
            ->assertSee('Student Deleted!')
            ->assertSee('The student has been deleted successfully.');

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    public function test_validation_errors_are_shown_in_the_form_and_alert(): void
    {
        $this->from(route('students.create'))
            ->post(route('students.store'), [
                'name' => '',
                'email' => 'not-an-email',
                'course' => '',
            ])
            ->assertRedirect(route('students.create'))
            ->assertSessionHasErrors(['name', 'email', 'course']);

        $this->get(route('students.create'))
            ->assertSee('Validation Error')
            ->assertSee('The name field is required.')
            ->assertSee('The email field must be a valid email address.')
            ->assertSee('name="course"', false);
    }

    public function test_student_index_has_a_confirmation_hook_and_delete_protection(): void
    {
        Student::create([
            'name' => 'Alex Student',
            'email' => 'alex@example.test',
            'course' => 'Computer Science',
        ]);

        $response = $this->get(route('students.index'))
            ->assertOk()
            ->assertSee('data-confirm-delete', false)
            ->assertSee('Are you sure?')
            ->assertSee('This student record will be deleted.')
            ->assertSee('Yes, delete it!')
            ->assertSee('Cancel')
            ->assertSee('name="_method" value="DELETE"', false)
            ->assertSee('name="_token"', false);

        $this->assertSame(1, substr_count($response->getContent(), 'sweetalert2@11'));
        $this->assertStringContainsString('if (result.isConfirmed)', $response->getContent());
        $this->assertStringContainsString('form.submit();', $response->getContent());
    }
}
