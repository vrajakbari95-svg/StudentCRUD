
public function up(): void
{
    Schema::table('students', function (Blueprint $table) {
        $table->string('name');
        $table->string('email')->unique();
        $table->string('course');
    });
}

public function down(): void
{
    Schema::table('students', function (Blueprint $table) {
        $table->dropUnique(['email']);
        $table->dropColumn(['name', 'email', 'course']);
    });
}
