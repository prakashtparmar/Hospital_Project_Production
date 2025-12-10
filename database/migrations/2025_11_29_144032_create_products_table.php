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
         Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('EmployeeNo', 20)->nullable();
            $table->string('EmployeeName')->nullable();
            $table->date('DateOfBirth')->nullable();
            $table->enum('Sex', ['male', 'female'])->nullable();
            $table->text('IdentificationMark')->nullable();
            $table->string('FathersName')->nullable();
            $table->enum('MaritalStatus', ['Married', 'Unmarried', 'Single', 'NA'])->nullable();
            $table->string('HusbandsName')->nullable();
            $table->text('Address')->nullable();
            $table->string('Dependent')->nullable();
            $table->string('Mobile', 20)->nullable();
            $table->string('JoiningDate', 20)->nullable();
            $table->date('DateOfExamination')->nullable();
            $table->text('Company')->nullable();
            $table->string('Department', 50)->nullable();
            $table->string('Designation', 50)->nullable();
            $table->text('H_OHabit')->nullable();
            $table->text('Prev_Occ_History')->nullable();
            $table->text('Temperature')->nullable();
            $table->text('Height')->nullable();
            $table->text('ChestBeforeBreathing')->nullable();
            $table->text('Pulse')->nullable();
            $table->text('Weight')->nullable();
            $table->text('ChestAfterBreathing')->nullable();
            $table->string('BP', 20)->nullable();
            $table->text('BMI')->nullable();
            $table->text('SpO2')->nullable();
            $table->text('RespirationRate')->nullable();
            $table->string('RightEyeSpecs')->nullable();
            $table->string('LeftEyeSpecs')->nullable();
            $table->string('NearVisionRight')->nullable();
            $table->string('NearVisionLeft')->nullable();
            $table->string('DistantVisionRight')->nullable();
            $table->string('DistantVisionLeft')->nullable();
            $table->string('ColourVision')->nullable();
            $table->string('Eye')->nullable();
            $table->string('Nose')->nullable();
            $table->string('Conjunctiva')->nullable();
            $table->string('Ear')->nullable();
            $table->string('Tongue')->nullable();
            $table->string('Nails')->nullable();
            $table->string('Throat')->nullable();
            $table->string('Skin')->nullable();
            $table->string('Teeth')->nullable();
            $table->string('PEFR')->nullable();
            $table->string('Eczema')->nullable();
            $table->string('Cyanosis')->nullable();
            $table->string('Jaundice')->nullable();
            $table->string('Anaemia')->nullable();
            $table->string('Oedema', 50)->nullable();
            $table->text('Clubbing')->nullable();
            $table->text('Allergy')->nullable();
            $table->string('Lymphnode', 50)->nullable();
            $table->text('KnownHypertension')->nullable();
            $table->text('Diabetes')->nullable();
            $table->text('Dyslipidemia')->nullable();
            $table->string('RadiationEffect')->nullable();
            $table->text('Vertigo')->nullable();
            $table->text('Tuberculosis')->nullable();
            $table->text('ThyroidDisorder')->nullable();
            $table->string('Epilepsy')->nullable();
            $table->string('Br_Asthma')->nullable();
            $table->string('HeartDisease')->nullable();
            $table->text('PresentComplain')->nullable();
            $table->string('Father')->nullable();
            $table->string('Mother')->nullable();
            $table->string('Brother')->nullable();
            $table->string('Sister')->nullable();
            $table->string('RespirationSystem')->nullable();
            $table->string('GenitoUrinary')->nullable();
            $table->string('CVS')->nullable();
            $table->string('CNS')->nullable();
            $table->string('PerAbdomen')->nullable();
            $table->string('ENT')->nullable();
            $table->string('PFT')->nullable();
            $table->string('XRayChest')->nullable();
            $table->string('VertigoTest')->nullable();
            $table->string('Audiometry')->nullable();
            $table->string('ECG')->nullable();
            $table->text('HB')->nullable();
            $table->text('WBC')->nullable();
            $table->text('Paasite')->nullable();
            $table->text('RBC')->nullable();
            $table->text('Platelet')->nullable();
            $table->text('ESR')->nullable();
            $table->text('FBS')->nullable();
            $table->text('PP2BS')->nullable();
            $table->text('SGPT')->nullable();
            $table->text('SCreatintine')->nullable();
            $table->text('RBS')->nullable();
            $table->text('SChol')->nullable();
            $table->text('STRG')->nullable();
            $table->text('SHDL')->nullable();
            $table->text('SLDL')->nullable();
            $table->text('CHRatio')->nullable();
            $table->string('UrineColour', 50)->nullable();
            $table->string('UrineReaction', 50)->nullable();
            $table->string('UrineAlbumin')->nullable();
            $table->string('UrineSugar')->nullable();
            $table->string('UrinePusCell')->nullable();
            $table->string('UrineRBC')->nullable();
            $table->string('UrineEpiCell')->nullable();
            $table->string('UrineCrystal', 50)->nullable();
            $table->string('HealthStatus')->nullable();
            $table->string('NameOfDoctor')->nullable();
            $table->string('DoctorSignature', 50)->nullable();
            $table->text('JobRestriction')->nullable();
            $table->string('ReviewedBy')->nullable();
            $table->text('DoctorsRemarks')->nullable();
            $table->text('HazardousProcess')->nullable();
            $table->text('DangerousOperation')->nullable();
            $table->text('Rawmaterials')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
