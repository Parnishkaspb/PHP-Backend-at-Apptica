<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Validators\DateValidator;
use App\Models\AppTopCategory;

class TopCategoryController extends Controller
{
    public function show(Request $request)
    {
        if (count($request->query()) !== 1 || !$request->has('date')) {
            return response()->json(['status_code' => 400, 'error' => 'Неверное количество параметров. Требуется только параметр date.'], 400, [], JSON_UNESCAPED_UNICODE);
        }

        if (!DateValidator::isValidDate($request->query('date'))) {
            return response()->json(['status_code' => 400, 'error' => 'Некорректный формат даты. Используйте формат YYYY-MM-DD.'], 400, [], JSON_UNESCAPED_UNICODE);
        }

        if (!DateValidator::isNotFutureDate($request->query('date'))) {
            return response()->json(['status_code' => 400, 'error' => 'Запрошенная дата не может быть позже сегодняшнего дня.'], 400, [], JSON_UNESCAPED_UNICODE);
        }

        $existingRecord = AppTopCategory::where([
            'id_application' => 1421444,
            'id_app' => 1,
            'date' => $request->query('date'),
        ])->first();
        
        if ($existingRecord) {

            return response()->json(['status_code' => 200, 'message' => 'ok', 'date' => $existingRecord->context], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['status_code' => 200, 'message' => 'ok', 'date' => 'Данные не найдены'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }
}