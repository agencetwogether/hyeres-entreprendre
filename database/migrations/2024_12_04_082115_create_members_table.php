<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->ulid()->index();
            $table->foreignIdFor(User::class, 'user_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->string('firstname');
            $table->string('name');
            $table->string('job')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->string('company_name')->nullable();
            $table->string('company_activity')->nullable();
            $table->longText('company_description')->nullable();
            $table->string('company_street')->nullable();
            $table->string('company_ext_street')->nullable();
            $table->string('company_postal_code')->nullable();
            $table->string('company_city')->nullable();
            $table->string('company_website')->nullable();
            $table->json('company_socials')->nullable();
            $table->boolean('is_partner')->default(false);
            $table->boolean('is_active')->default(false);
            $table->boolean('is_published')->default(false);
            $table->boolean('account_created')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
