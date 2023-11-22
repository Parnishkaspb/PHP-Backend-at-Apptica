<?php 
namespace App\Services;

class JsonProcessor
{
    public function process($jsonString)
    {
        $data = json_decode($jsonString, true)['data'];

        $minValuesByKey = [];
        $formattedResult = [];

        // Собираем минимальные значения для каждой даты по ключам
        foreach ($data as $firstKey => $groupData) {
            foreach ($groupData as $subData) {
                foreach ($subData as $date => $value) {
                    if ($value !== null) {
                        if (!isset($minValuesByKey[$firstKey][$date]) || $minValuesByKey[$firstKey][$date] > $value) {
                            $minValuesByKey[$firstKey][$date] = $value;
                        }
                    }
                }
            }
        }

        // Форматируем результаты так, чтобы даты были ключами
        foreach ($minValuesByKey as $key => $dateValues) {
            foreach ($dateValues as $date => $value) {
                $formattedResult[$date][$key] = $value;
            }
        }

        return json_encode($formattedResult);
    }
}
