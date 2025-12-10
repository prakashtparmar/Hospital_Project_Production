<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\Controller;
use PDF;

class PDFController extends Controller
{
    public function generatePDF($id, $template = 'mypdf')
    {
        $product = Product::findOrFail($id);

        // Check if template exists
        if (!view()->exists("admin.products.$template")) {
            abort(404, 'PDF template not found.');
        }

        $pdf = PDF::loadView("admin.products.$template", compact('product'))
                  ->setPaper('a4');

        $fileName = 'Employee-Health-Record-' . $product->EmployeeName . '.pdf';

        return $pdf->stream($fileName, ['Attachment' => false]);
    }
}
