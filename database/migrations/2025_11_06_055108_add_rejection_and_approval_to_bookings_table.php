<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Add rejection_reason column if it doesn't exist
            if (!Schema::hasColumn('bookings', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('remarks');
            }

            // Add approved_by column if it doesn't exist
            if (!Schema::hasColumn('bookings', 'approved_by')) {
                $table->unsignedBigInteger('approved_by')->nullable()->after('rejection_reason');
            }

            // Add approved_at column if it doesn't exist
            if (!Schema::hasColumn('bookings', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }

            // Add foreign key for approved_by if it doesn't exist
            if (!Schema::hasColumn('bookings', 'approved_by') || !$this->hasConstraint('bookings', 'approved_by_foreign')) {
                $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Drop foreign key
            $table->dropForeignIfExists('bookings_approved_by_foreign');

            // Drop columns
            $table->dropColumn('rejection_reason');
            $table->dropColumn('approved_by');
            $table->dropColumn('approved_at');
        });
    }

    /**
     * Check if a constraint exists
     */
    private function hasConstraint($table, $constraintName)
    {
        $indexColumns = Schema::getConnection()
            ->getDoctrineSchemaManager()
            ->listTableForeignKeys($table);

        foreach ($indexColumns as $index) {
            if ($index->getName() == $constraintName) {
                return true;
            }
        }

        return false;
    }
};