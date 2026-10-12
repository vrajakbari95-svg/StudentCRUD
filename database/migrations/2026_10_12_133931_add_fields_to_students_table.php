<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const OWNERSHIP_TABLE = 'student_fields_20261012133931_ownership';
    private const EMAIL_INDEX = 'students_email_unique_20261012133931';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable(self::OWNERSHIP_TABLE)) {
            Schema::create(self::OWNERSHIP_TABLE, function (Blueprint $table) {
                $table->string('object_name')->primary();
                $table->string('object_type');
            });
        }

        foreach (['name', 'email', 'course'] as $column) {
            if (Schema::hasColumn('students', $column)) {
                continue;
            }

            DB::table(self::OWNERSHIP_TABLE)->updateOrInsert(
                ['object_name' => $column],
                ['object_type' => 'column']
            );

            Schema::table('students', function (Blueprint $table) use ($column) {
                $table->string($column)->nullable();
            });
        }

        $hasUniqueEmailIndex = collect(Schema::getIndexes('students'))->contains(
            fn (array $index): bool => $index['unique'] && $index['columns'] === ['email']
        );

        if (! $hasUniqueEmailIndex) {
            DB::table(self::OWNERSHIP_TABLE)->updateOrInsert(
                ['object_name' => self::EMAIL_INDEX],
                ['object_type' => 'index']
            );

            Schema::table('students', function (Blueprint $table) {
                $table->unique('email', self::EMAIL_INDEX);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable(self::OWNERSHIP_TABLE)) {
            return;
        }

        $ownedObjects = DB::table(self::OWNERSHIP_TABLE)->get()->keyBy('object_name');

        if ($ownedObjects->has(self::EMAIL_INDEX) && Schema::hasTable('students')) {
            $hasOwnedIndex = collect(Schema::getIndexes('students'))->contains(
                fn (array $index): bool => $index['name'] === self::EMAIL_INDEX
            );

            if ($hasOwnedIndex) {
                Schema::table('students', function (Blueprint $table) {
                    $table->dropUnique(self::EMAIL_INDEX);
                });
            }
        }

        $createdColumns = collect(['name', 'email', 'course'])
            ->filter(fn (string $column): bool => $ownedObjects->has($column))
            ->filter(fn (string $column): bool => Schema::hasColumn('students', $column))
            ->values()
            ->all();

        if ($createdColumns !== []) {
            Schema::table('students', function (Blueprint $table) use ($createdColumns) {
                $table->dropColumn($createdColumns);
            });
        }

        Schema::drop(self::OWNERSHIP_TABLE);
    }
};
