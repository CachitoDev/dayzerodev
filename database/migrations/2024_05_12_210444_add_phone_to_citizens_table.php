<?php

use App\Models\TeamLeader;
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
        Schema::table('citizens', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('curp')->nullable()->change();
            $table->string('phone')->nullable();
            $table->string('image_path')->nullable()->change();
            $table->string('latitude')->nullable()->change();
            $table->string('longitude')->nullable()->change();
            $table->foreignIdFor(TeamLeader::class)->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citizens', function (Blueprint $table) {
            $table->dropForeign(['team_leader_id']);
            $table->dropColumn(['name', 'phone', 'team_leader_id']);
            $table->string('curp')->nullable()->change();
            $table->string('image_path')->nullable()->change();
            $table->string('latitude')->nullable()->change();
            $table->string('longitude')->nullable()->change();
        });
    }
};