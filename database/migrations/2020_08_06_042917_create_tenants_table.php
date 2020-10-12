<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_name');
            $table->string('email')->unique();
            // $table->string('no_KTP',16)->unique();
            $table->string('IDcard_number')->unique();
            $table->enum('type_IDcard',['KTP','Passport','SIM'])->default('KTP');
            $table->string('no_HP',15);
            $table->text('address');
            $table->enum('status',['active','inactive'])->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenants');
    }
}
