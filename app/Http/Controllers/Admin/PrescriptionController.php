<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    /* STORE FULL PRESCRIPTION */
    public function store(Request $request, Consultation $consultation)
    {
        $data = $request->validate([
            'notes'                 => 'nullable|string',
            'items'                 => 'required|array|min:1',
            'items.*.drug_name'     => 'required|string',
            'items.*.strength'      => 'nullable|string',
            'items.*.dose'          => 'nullable|string',
            'items.*.route'         => 'nullable|string',
            'items.*.frequency'     => 'nullable|string',
            'items.*.duration'      => 'nullable|string',
            'items.*.instructions'  => 'nullable|string',
        ]);

        $prescription = Prescription::create([
            'consultation_id' => $consultation->id,
            'patient_id'      => $consultation->patient_id,
            'doctor_id'       => Auth::id(),
            'prescribed_on'   => now(),
            'notes'           => $data['notes'] ?? null,
        ]);

        foreach ($data['items'] as $item) {
            $prescription->items()->create($item);
        }

        return redirect()
            ->route('consultations.show', $consultation)
            ->with('success', 'Prescription saved.');
    }

    /* PRINT VIEW */
    public function print(Prescription $prescription)
    {
        $prescription->load(['patient','doctor','items']);
        return view('prescriptions.print', compact('prescription'));
    }

    /* PDF */
    public function generatePdf($id)
    {
        $prescription = Prescription::with(['patient','doctor','items'])
            ->findOrFail($id);

        $pdf = \PDF::loadView('admin.prescriptions.pdf', [
            'prescription' => $prescription
        ]);

        return $pdf->download('prescription-'.$prescription->id.'.pdf');
    }

    /* AJAX — ADD ITEM */
    public function storeItem(Request $request)
    {
        $request->validate([
            'consultation_id' => 'required|exists:consultations,id',
            'drug_name'       => 'required|string|max:255',
        ]);

        $item = PrescriptionItem::create([
            'prescription_id' => $request->prescription_id,
            'drug_name'       => $request->drug_name,
            'strength'        => $request->strength,
            'dose'            => $request->dose,
            'route'           => $request->route,
            'frequency'       => $request->frequency,
            'duration'        => $request->duration,
            'instructions'    => $request->instructions,
        ]);

        return response()->json(['status' => 'success', 'item' => $item]);
    }

    /* AJAX — DELETE ITEM */
    public function deleteItem($id)
    {
        $item = PrescriptionItem::findOrFail($id);
        $item->delete();

        return response()->json(['status' => 'success']);
    }

    /* AJAX — SAVE NOTES */
    public function updateNotes(Request $request)
    {
        $request->validate([
            'prescription_id' => 'required|exists:prescriptions,id',
            'notes'           => 'nullable|string',
        ]);

        $prescription = Prescription::find($request->prescription_id);
        $prescription->notes = $request->notes;
        $prescription->save();

        return response()->json(['status' => 'saved']);
    }
}
