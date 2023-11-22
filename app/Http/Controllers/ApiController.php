<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Validators\DateValidator;
use Illuminate\Support\Facades\Http;
use App\Services\JsonProcessor;
use Illuminate\Support\Facades\Log;
use App\Models\AppTopCategory;

class ApiController extends Controller
{
    public function submitForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'countryId' => 'required|integer|gt:0',
            'applicationId' => 'required|integer|gt:0',
            'dateFrom' => 'required|date',
            'dateTo' => 'required|date|after_or_equal:dateFrom'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status_code'=> 400, 'errors' => $validator->errors()], 400);
        }
    
        if (!DateValidator::areValidDates($request->input('dateFrom'), $request->input('dateTo'))) {
            return response()->json(['status_code'=> 400, 'errors' => 'Некорректный формат даты. Используйте формат YYYY-MM-DD.'], 400);
        }        
        
        $applicationId = $request->input('applicationId');
        $countryId = $request->input('countryId');
        $dateFrom = $request->input('dateFrom');
        $dateTo = $request->input('dateTo');

        $url = "https://api.apptica.com/package/top_history/{$applicationId}/{$countryId}?date_from={$dateFrom}&date_to={$dateTo}&B4NKGg=fVN5Q9KVOlOHDx9mOsKPAQsFBlEhBOwguLkNEDTZvKzJzT3l";

        try {
            $response = Http::get($url);
    
            if ($response->successful()) {
                $responseData = json_encode($response->json());
                $processor = new JsonProcessor();
                $resultJson = $processor->process($responseData);
                $resultJson = json_decode($resultJson, true);

                foreach ($resultJson as $date => $data) {
                    Log::info("". $date);
                    $existingRecord = AppTopCategory::where([
                        'id_application' => $applicationId,
                        'id_app' => $countryId,
                        'date' => $date,
                    ])->first();
                    if (!$existingRecord) {
                        $record = AppTopCategory::firstOrNew([
                            'id_application' => $applicationId,
                            'id_app' => $countryId,
                            'date' => $date,
                            'context' => json_encode($resultJson[$date]),
                        ]);
                        $record->save();
                    }
                }

                return redirect()->back()->with(['status_code' => 200, 'success', 'Данные успешно отправлены.']);
            } else {
                return response()->json(['status_code'=> 500, 'errors' => 'Ошибка при отправке данных на API.'], 500, [], JSON_UNESCAPED_UNICODE);
            }

        } catch (\Exception $e) {
            Log::error('Ошибка при запросе к API: ' . $e->getMessage());

            return response()->json(['status_code'=> 500, 'errors' => 'Ошибка при отправке запроса: ' . $e->getMessage()], 500);
        }
    }
}
