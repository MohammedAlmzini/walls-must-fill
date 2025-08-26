<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShipCampaignSurvey;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdminShipCampaignController extends Controller
{
    public function index()
    {
        $surveys = ShipCampaignSurvey::latest()->paginate(20);
        $totalSurveys = ShipCampaignSurvey::count();
        
        return view('admin.ship-campaign.index', compact('surveys', 'totalSurveys'));
    }

    public function show(ShipCampaignSurvey $survey)
    {
        return view('admin.ship-campaign.show', compact('survey'));
    }

    public function destroy(ShipCampaignSurvey $survey)
    {
        try {
            $survey->delete();
            return redirect()->route('admin.ship-campaign.index')
                ->with('success', app()->getLocale() === 'ar' ? 'تم حذف الاستطلاع بنجاح' : 'Survey deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.ship-campaign.index')
                ->with('error', app()->getLocale() === 'ar' ? 'حدث خطأ أثناء حذف الاستطلاع' : 'Error occurred while deleting survey');
        }
    }

    public function exportExcel()
    {
        $surveys = ShipCampaignSurvey::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = [
            'ID',
            'الاسم الأول',
            'الاسم الأخير',
            'رقم الواتساب',
            'البريد الإلكتروني',
            'العمر',
            'السؤال الأول',
            'السؤال الثاني',
            'السؤال الثالث',
            'السؤال الرابع',
            'السؤال الخامس',
            'تاريخ الإنشاء',
            'تاريخ التحديث'
        ];

        $sheet->fromArray($headers, NULL, 'A1');

        // Add data
        $row = 2;
        foreach ($surveys as $survey) {
            $sheet->setCellValue('A' . $row, $survey->id);
            $sheet->setCellValue('B' . $row, $survey->first_name);
            $sheet->setCellValue('C' . $row, $survey->last_name);
            $sheet->setCellValue('D' . $row, $survey->whatsapp_number);
            $sheet->setCellValue('E' . $row, $survey->email);
            $sheet->setCellValue('F' . $row, $survey->age);
            $sheet->setCellValue('G' . $row, $survey->question1_answer);
            $sheet->setCellValue('H' . $row, $survey->question2_answer);
            $sheet->setCellValue('I' . $row, $survey->question3_answer);
            $sheet->setCellValue('J' . $row, $survey->question4_answer);
            $sheet->setCellValue('K' . $row, $survey->question5_answer);
            $sheet->setCellValue('L' . $row, $survey->created_at->format('Y-m-d H:i:s'));
            $sheet->setCellValue('M' . $row, $survey->updated_at->format('Y-m-d H:i:s'));
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'M') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'ship_campaign_surveys_' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:ship_campaign_surveys,id'
        ]);

        try {
            ShipCampaignSurvey::whereIn('id', $request->ids)->delete();
            return response()->json([
                'success' => true,
                'message' => app()->getLocale() === 'ar' ? 'تم حذف الاستطلاعات المحددة بنجاح' : 'Selected surveys deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() === 'ar' ? 'حدث خطأ أثناء حذف الاستطلاعات' : 'Error occurred while deleting surveys'
            ], 500);
        }
    }
}
