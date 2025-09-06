<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFhirResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fhir_resources', function (Blueprint $table) {
            $table->id();
            $table->string('resource_type'); // Patient, Encounter, Observation, etc.
            $table->string('name');
            $table->text('description');
            $table->json('example_data'); // JSON con ejemplo de recurso FHIR
            $table->text('explanation')->nullable();
            $table->string('chile_core_profile')->nullable(); // URL del perfil chileno
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('fhir_resources');
    }
}
