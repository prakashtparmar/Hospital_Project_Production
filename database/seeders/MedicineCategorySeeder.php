<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicineCategory;
use Illuminate\Support\Str;

class MedicineCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [

            // General
            ['name' => 'Antibiotics', 'description' => 'Broad-spectrum and targeted antibacterial medicines.', 'status' => 1],
            ['name' => 'Antivirals', 'description' => 'Medicines used to treat viral infections.', 'status' => 1],
            ['name' => 'Antifungals', 'description' => 'Drugs to treat fungal infections.', 'status' => 1],
            ['name' => 'Antimalarials', 'description' => 'Medicines used for malaria treatment and prevention.', 'status' => 1],
            ['name' => 'Pain Killers (Analgesics)', 'description' => 'Pain relief medicines for various conditions.', 'status' => 1],
            ['name' => 'Anti-inflammatory (NSAIDs)', 'description' => 'Non-steroidal anti-inflammatory drugs.', 'status' => 1],
            ['name' => 'Antipyretics', 'description' => 'Medicines used to reduce fever.', 'status' => 1],

            // Chronic Disease
            ['name' => 'Diabetes Medicines', 'description' => 'Oral and injectable anti-diabetic medications.', 'status' => 1],
            ['name' => 'Hypertension Medicines', 'description' => 'Medications for controlling blood pressure.', 'status' => 1],
            ['name' => 'Cardiac Medicines', 'description' => 'Drugs used for heart-related conditions.', 'status' => 1],
            ['name' => 'Cholesterol / Lipid Lowering', 'description' => 'Medicines to manage lipid profiles.', 'status' => 1],

            // Specialist Medicines
            ['name' => 'Neurology', 'description' => 'Medicines for neurological disorders.', 'status' => 1],
            ['name' => 'Psychiatry', 'description' => 'Mental health treatment medicines.', 'status' => 1],
            ['name' => 'Oncology', 'description' => 'Anti-cancer drugs and chemotherapy agents.', 'status' => 1],
            ['name' => 'Gastroenterology', 'description' => 'Medicines for digestive system disorders.', 'status' => 1],
            ['name' => 'Pulmonology', 'description' => 'Respiratory system treatment medicines.', 'status' => 1],
            ['name' => 'Dermatology', 'description' => 'Skin-related medicines and ointments.', 'status' => 1],
            ['name' => 'Nephrology', 'description' => 'Medicines for kidney-related conditions.', 'status' => 1],
            ['name' => 'ENT Medicines', 'description' => 'Ear, nose, and throat medicines.', 'status' => 1],

            // OTC & Supportive
            ['name' => 'Vitamins & Supplements', 'description' => 'General health supplements and vitamins.', 'status' => 1],
            ['name' => 'Minerals', 'description' => 'Essential mineral supplements.', 'status' => 1],
            ['name' => 'Protein Supplements', 'description' => 'Nutritional and bodybuilding protein supplements.', 'status' => 1],
            ['name' => 'Immunity Boosters', 'description' => 'Supplements that enhance immunity.', 'status' => 1],

            // Children & Women
            ['name' => 'Pediatrics', 'description' => 'Children-specific medicines and formulations.', 'status' => 1],
            ['name' => 'Gynecology', 'description' => 'Women’s health and gynecological medicines.', 'status' => 1],
            ['name' => 'Maternity Medicines', 'description' => 'Medicines used in pregnancy and postnatal care.', 'status' => 1],

            // OTC Products
            ['name' => 'Cough & Cold', 'description' => 'Medicines for cough, cold, and flu symptoms.', 'status' => 1],
            ['name' => 'Allergy (Antihistamines)', 'description' => 'Anti-allergic medicines including antihistamines.', 'status' => 1],
            ['name' => 'Digestive / Acidity', 'description' => 'Acidity, gas, and digestion medicines.', 'status' => 1],
            ['name' => 'Oral Care', 'description' => 'Mouthwashes, oral gels, and dental hygiene products.', 'status' => 1],

            // Emergency & Critical
            ['name' => 'Emergency Medicines', 'description' => 'Emergency and lifesaving drugs.', 'status' => 1],
            ['name' => 'ICU Medicines', 'description' => 'Intensive care unit drugs and injections.', 'status' => 1],
            ['name' => 'Anesthetics', 'description' => 'Local and general anesthetic medicines.', 'status' => 1],

            // Form-based classification
            ['name' => 'Tablets', 'description' => 'Tablet-form medicines.', 'status' => 1],
            ['name' => 'Capsules', 'description' => 'Capsule-form medicines.', 'status' => 1],
            ['name' => 'Syrups', 'description' => 'Liquid oral syrups.', 'status' => 1],
            ['name' => 'Injections', 'description' => 'Injectable medicines and vaccines.', 'status' => 1],
            ['name' => 'IV Fluids', 'description' => 'Intravenous fluids and drips.', 'status' => 1],
            ['name' => 'Drops (Eye/Ear/Nasal)', 'description' => 'Liquid drops for ENT and ophthalmic use.', 'status' => 1],
            ['name' => 'Ointments & Creams', 'description' => 'Topical creams, gels, and ointments.', 'status' => 1],

            // Surgical / Others
            ['name' => 'First Aid', 'description' => 'First aid medicines and materials.', 'status' => 1],
            ['name' => 'Surgical Items', 'description' => 'Surgical consumables and sterile items.', 'status' => 1],
            ['name' => 'Disinfectants & Antiseptics', 'description' => 'Surface and skin disinfectants.', 'status' => 1],
            ['name' => 'Ayurvedic Medicines', 'description' => 'Herbal and ayurvedic medicines.', 'status' => 1],
            ['name' => 'Homeopathic Medicines', 'description' => 'Homeopathic treatment medicines.', 'status' => 1],
        ];

        foreach ($categories as $cat) {
            MedicineCategory::firstOrCreate(
                ['name' => $cat['name']],
                [
                    'slug'        => Str::slug($cat['name']) . '-' . uniqid(),
                    'description' => $cat['description'] ?? null,
                    'status'      => $cat['status']
                ]
            );
        }
    }
}
