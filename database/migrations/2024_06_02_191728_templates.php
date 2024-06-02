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
        Schema::create('templates', function (Blueprint $table) {
			$table->id();
			$table->string('name', 100)->unique()->index('idx_name');
			$table->string('subject', 2000);
			$table->json('fallback_to')->nullable();
			$table->json('fallback_cc')->nullable();
			$table->json('fallback_bcc')->nullable();
			$table->string('fallback_return_path')->nullable();
			$table->string('fallback_reply_to')->nullable();
			$table->json('content');
			$table->boolean('is_published')->default(false);
	    	$table->timestamp('created_at')->useCurrent(); // not used laravel timestamps because they are nullable
		    $table->timestamp('updated_at')->useCurrent(); // not used laravel timestamps because they are nullable
            $table->timestamp('deleted_at')->nullable();
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
