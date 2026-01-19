<?php

use App\Enums\StatusContact;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('firstname');
            $table->string('email');
            $table->string('phone');
            $table->longText('content');
            $table->boolean('rgpd')->default(false);
            $table->boolean('response_sent')->default(false);
            $table->datetime('response_date')->nullable();
            $table->string('response_subject')->nullable();
            $table->longText('response_content')->nullable();
            $table->boolean('subscription_received')->default(false);
            $table->string('status')->default(StatusContact::CREATED);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
