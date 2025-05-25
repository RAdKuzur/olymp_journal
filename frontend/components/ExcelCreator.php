<?php
namespace frontend\components;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;
use yii\web\Response;

class ExcelCreator
{
    public const SUBJECT = [
        'RUSSIAN' => [
            'filepath' => '/templates/russian.xlsx',
            'registerList' => [
                'name' => 'лист регистрации',
                'index' => 0,
                'startCell' => ['A', 3]
            ],
            'auditoriumList' => [
                'name' => 'список по аудитории',
                'index' => 1,
                'startCell' => ['A', 3]
            ],
            'appearanceList' => [
                'name' => 'явка',
                'index' => 2,
                'startCell' => ['A', 3]
            ],
            'pointLists' => [
                [
                    'name' => '9 класс',
                    'category' => [9],
                    'index' => 3,
                    'participantCell' => NULL,
                    'codeCell' => ['B', 6],
                    'pointCell' => ['C', 6],
                    'ignoreColumns' => [],
                ],
                [
                    'name' => '10 класс',
                    'category' => [10],
                    'index' => 4,
                    'participantCell' => NULL,
                    'codeCell' => ['B', 6],
                    'pointCell' => ['C', 6],
                    'ignoreColumns' => [],
                ],
                [
                    'name' => '11 класс',
                    'category' => [11],
                    'index' => 5,
                    'participantCell' => NULL,
                    'codeCell' => ['B', 6],
                    'pointCell' => ['C', 6],
                    'ignoreColumns' => [],
                ]
            ],
            'ratingList' => [
                'name' => 'Предварительный рейтинг',
                'index' => 6,
                'startCell' => ['A', 4]
            ],
            'formApplicationList' => [
                'name' => 'форма приложения к протоколу',
                'index' => 7,
                'startCell' => ['A', 6]
            ],
            'formProtocolList' => [
                'name' => 'форма протокола обезличенная',
                'index' => 8,
                'startCell' => ['A', 6]
            ],
            'formESUList' => [
                'name' => 'Форма ЭСУ',
                'index' => 8,
                'startCell' => ['A', 5]
            ]
        ]
    ];
    public static function createForm($data)
    {
        $templatePath = Yii::$app->basePath . self::SUBJECT[$data['subject_code']]['filepath'];
        if (!file_exists($templatePath)) {
            throw new \Exception('Шаблонный файл не найден');
        }
        $spreadsheet = IOFactory::load($templatePath);

        self::fillRegisterList($spreadsheet, $data);
        self::fillAuditoriumList($spreadsheet, $data);
        self::fillAppearanceList($spreadsheet, $data);
        self::fillPointLists($spreadsheet, $data);
        self::fillRatingList($spreadsheet, $data);
        self::fillFormApplicationList($spreadsheet, $data);
        self::fillFormProtocolList($spreadsheet, $data);
        self::fillFormEsuList($spreadsheet, $data);

        $outputFilename = 'OLYMP_' . $data['subject_code'] . '.xlsx';
        $outputPath = Yii::getAlias('@runtime/' . $outputFilename);
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($outputPath);
        $response = Yii::$app->response;
        $response->sendFile($outputPath, $outputFilename, [
            'mimeType' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'inline' => false
        ])->on(Response::EVENT_AFTER_SEND, function($event) use ($outputPath) {
            if (file_exists($outputPath)) {
                unlink($outputPath);
            }
        });
        return $response;
    }
    public static function fillRegisterList($spreadsheet, $data)
    {
        $sheet = $spreadsheet->getSheetByName(self::SUBJECT[$data['subject_code']]['registerList']['name']);
        foreach ($data['data'] as $i => $item) {
            $columnIndex = Coordinate::columnIndexFromString(self::SUBJECT[$data['subject_code']]['registerList']['startCell'][0]);
            $rowIndex = self::SUBJECT[$data['subject_code']]['registerList']['startCell'][1];
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex + $i, $item['participant']->surname);
            $sheet->setCellValueByColumnAndRow($columnIndex + 1, $rowIndex + $i, $item['participant']->name);
            $sheet->setCellValueByColumnAndRow($columnIndex + 2, $rowIndex + $i, $item['participant']->patronymic);
            $sheet->setCellValueByColumnAndRow($columnIndex + 3, $rowIndex + $i, Yii::$app->formatter->asDate($item['participant']->birthdate, 'php:d.m.Y'));
            $sheet->setCellValueByColumnAndRow($columnIndex + 4, $rowIndex + $i, $item['application']->subjectCategory->category . ' ' . 'класс');
            $sheet->setCellValueByColumnAndRow($columnIndex + 5, $rowIndex + $i, $item['participant']->school->name);
        }
    }
    public static function fillAuditoriumList($spreadsheet, $data)
    {
        $sheet = $spreadsheet->getSheetByName(self::SUBJECT[$data['subject_code']]['auditoriumList']['name']);
        foreach ($data['data'] as $i => $item) {
            $columnIndex = Coordinate::columnIndexFromString(self::SUBJECT[$data['subject_code']]['auditoriumList']['startCell'][0]);
            $rowIndex = self::SUBJECT[$data['subject_code']]['auditoriumList']['startCell'][1];
            $sheet->setCellValueByColumnAndRow($columnIndex + 1, $rowIndex + $i, $item['participant']->surname);
            $sheet->setCellValueByColumnAndRow($columnIndex + 2, $rowIndex + $i, $item['participant']->name);
            $sheet->setCellValueByColumnAndRow($columnIndex + 3, $rowIndex + $i, $item['participant']->patronymic);
            $sheet->setCellValueByColumnAndRow($columnIndex + 4, $rowIndex + $i, Yii::$app->formatter->asDate($item['participant']->birthdate, 'php:d.m.Y'));
            $sheet->setCellValueByColumnAndRow($columnIndex + 5, $rowIndex + $i, $item['application']->subjectCategory->category . ' ' . 'класс');
        }
    }
    public static function fillAppearanceList($spreadsheet, $data){
        $sheet = $spreadsheet->getSheetByName(self::SUBJECT[$data['subject_code']]['appearanceList']['name']);
        foreach ($data['data'] as $i => $item) {
            $columnIndex = Coordinate::columnIndexFromString(self::SUBJECT[$data['subject_code']]['appearanceList']['startCell'][0]);
            $rowIndex = self::SUBJECT[$data['subject_code']]['appearanceList']['startCell'][1];
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex + $i, $item['participant']->surname);
            $sheet->setCellValueByColumnAndRow($columnIndex + 1, $rowIndex + $i, $item['participant']->name);
            $sheet->setCellValueByColumnAndRow($columnIndex + 2, $rowIndex + $i, $item['participant']->patronymic);
            $sheet->setCellValueByColumnAndRow($columnIndex + 3, $rowIndex + $i, Yii::$app->formatter->asDate($item['participant']->birthdate, 'php:d.m.Y'));
            $sheet->setCellValueByColumnAndRow($columnIndex + 4, $rowIndex + $i, $item['application']->subjectCategory->category . ' ' . 'класс');
            $sheet->setCellValueByColumnAndRow($columnIndex + 5, $rowIndex + $i, $item['application']->code);
            $sheet->setCellValueByColumnAndRow($columnIndex + 6, $rowIndex + $i, $item['appearance'][0]->status);
        }
    }
    public static function fillPointLists($spreadsheet, $data)
    {
        $lists = self::SUBJECT[$data['subject_code']]['pointLists'];
        foreach ($lists as $list){
            $counter = 0;
            $sheet = $spreadsheet->getSheetByName($list['name']);
            foreach ($data['data'] as $item) {
                $columnIndex = Coordinate::columnIndexFromString($list['codeCell'][0]);
                $rowIndex = $list['codeCell'][1];
                if(in_array($item['category']->category, $list['category']) && $item['appearance'][0]->status == 1){
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex + $counter, $item['application']->code);
                    foreach($item['taskApplications'] as $i => $taskApplication){
                        $pointColumnIndex = Coordinate::columnIndexFromString($list['pointCell'][0]);
                        $pointRowIndex = $list['pointCell'][1];
                        $sheet->setCellValueByColumnAndRow($pointColumnIndex + $i, $pointRowIndex + $counter, $taskApplication->points);
                    }
                    $counter++;
                }
            }
        }
    }
    public static function fillRatingList($spreadsheet, $data)
    {
        $sheet = $spreadsheet->getSheetByName(self::SUBJECT[$data['subject_code']]['ratingList']['name']);
        $columnIndex = Coordinate::columnIndexFromString(self::SUBJECT[$data['subject_code']]['ratingList']['startCell'][0]);
        $rowIndex = self::SUBJECT[$data['subject_code']]['ratingList']['startCell'][1];
        $counter = 0;
        $oldCategory = 0;
        $categoryIndex = 1;
        foreach ($data['data'] as $item) {
            if ($oldCategory != $item['category']->category) {
                $sheet->mergeCells('A' . ($rowIndex + $counter) . ':E' . ($rowIndex + $counter));
                $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex + $counter, $item['category']->category . ' ' . 'класс');
                $cellCoordinate = Coordinate::stringFromColumnIndex($columnIndex) . ($rowIndex + $counter);
                $sheet->getStyle($cellCoordinate)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($cellCoordinate)->getFont()->setBold(true);
                $categoryIndex = 1;
                $counter++;
            }
            if($item['appearance'][0]->status == 1) {
                $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex + $counter, $categoryIndex);
                $sheet->setCellValueByColumnAndRow($columnIndex + 1, $rowIndex + $counter, $item['application']->participant->getFullFio());
                $sheet->setCellValueByColumnAndRow($columnIndex + 2, $rowIndex + $counter, $item['application']->participant->school->name);
                $sheet->setCellValueByColumnAndRow($columnIndex + 3, $rowIndex + $counter, $item['application']->participant->class . ' ' . 'класс');
                $sheet->setCellValueByColumnAndRow($columnIndex + 4, $rowIndex + $counter, $item['application']->getTotalScore());
                $oldCategory = $item['category']->category;
                $counter++;
                $categoryIndex++;
            }
        }
    }
    public static function fillFormApplicationList($spreadsheet, $data){
        $sheet = $spreadsheet->getSheetByName(self::SUBJECT[$data['subject_code']]['formApplicationList']['name']);
        $columnIndex = Coordinate::columnIndexFromString(self::SUBJECT[$data['subject_code']]['formApplicationList']['startCell'][0]);
        $rowIndex = self::SUBJECT[$data['subject_code']]['formApplicationList']['startCell'][1];
        $counter = 0;
        $oldCategory = 0;
        $categoryIndex = 1;
        foreach ($data['data'] as $item) {
            if ($oldCategory != $item['category']->category) {
                $sheet->mergeCells('A' . ($rowIndex + $counter) . ':G' . ($rowIndex + $counter));
                $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex + $counter, $item['category']->category . ' ' . 'класс');
                $cellCoordinate = Coordinate::stringFromColumnIndex($columnIndex) . ($rowIndex + $counter);
                $sheet->getStyle($cellCoordinate)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($cellCoordinate)->getFont()->setBold(true);
                $categoryIndex = 1;
                $counter++;
            }
            if($item['appearance'][0]->status == 1) {
                $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex + $counter, $categoryIndex);
                $sheet->setCellValueByColumnAndRow($columnIndex + 1, $rowIndex + $counter, $item['application']->participant->getFullFio());
                $sheet->setCellValueByColumnAndRow($columnIndex + 2, $rowIndex + $counter, $item['application']->code);
                $sheet->setCellValueByColumnAndRow($columnIndex + 3, $rowIndex + $counter, $item['application']->participant->school->name);
                $sheet->setCellValueByColumnAndRow($columnIndex + 4, $rowIndex + $counter, $item['application']->participant->class . ' ' . 'класс');
                $sheet->setCellValueByColumnAndRow($columnIndex + 5, $rowIndex + $counter, $item['application']->getTotalScore());
                $sheet->setCellValueByColumnAndRow($columnIndex + 6, $rowIndex + $counter, $item['application']->setStatus());
                $oldCategory = $item['category']->category;
                $counter++;
                $categoryIndex++;
            }
        }
    }
    public static function fillFormProtocolList($spreadsheet, $data){
        $sheet = $spreadsheet->getSheetByName(self::SUBJECT[$data['subject_code']]['formProtocolList']['name']);
        $columnIndex = Coordinate::columnIndexFromString(self::SUBJECT[$data['subject_code']]['formProtocolList']['startCell'][0]);
        $rowIndex = self::SUBJECT[$data['subject_code']]['formProtocolList']['startCell'][1];
        $counter = 0;
        $oldCategory = 0;
        $categoryIndex = 1;
        foreach ($data['data'] as $item) {
            if ($oldCategory != $item['category']->category) {
                $sheet->mergeCells('A' . ($rowIndex + $counter) . ':G' . ($rowIndex + $counter));
                $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex + $counter, $item['category']->category . ' ' . 'класс');
                $cellCoordinate = Coordinate::stringFromColumnIndex($columnIndex) . ($rowIndex + $counter);
                $sheet->getStyle($cellCoordinate)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($cellCoordinate)->getFont()->setBold(true);
                $categoryIndex = 1;
                $counter++;
            }
            if($item['appearance'][0]->status == 1) {
                $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex + $counter, $categoryIndex);
                $sheet->setCellValueByColumnAndRow($columnIndex + 1, $rowIndex + $counter, $item['application']->code);
                $sheet->setCellValueByColumnAndRow($columnIndex + 2, $rowIndex + $counter, $item['application']->participant->school->name);
                $sheet->setCellValueByColumnAndRow($columnIndex + 3, $rowIndex + $counter, $item['application']->participant->class . ' ' . 'класс');
                $sheet->setCellValueByColumnAndRow($columnIndex + 4, $rowIndex + $counter, $item['application']->getTotalScore());
                $sheet->setCellValueByColumnAndRow($columnIndex + 5, $rowIndex + $counter, $item['application']->setStatus());
                $oldCategory = $item['category']->category;
                $counter++;
                $categoryIndex++;
            }
        }
    }
    public static function fillFormEsuList($spreadsheet, $data){
        $sheet = $spreadsheet->getSheetByName(self::SUBJECT[$data['subject_code']]['formESUList']['name']);
        foreach ($data['data'] as $i => $item) {
            $columnIndex = Coordinate::columnIndexFromString(self::SUBJECT[$data['subject_code']]['formESUList']['startCell'][0]);
            $rowIndex = self::SUBJECT[$data['subject_code']]['formESUList']['startCell'][1];
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex + $i, 'Астраханская область');
            $sheet->setCellValueByColumnAndRow($columnIndex + 1, $rowIndex + $i, $item['participant']->surname);
            $sheet->setCellValueByColumnAndRow($columnIndex + 2, $rowIndex + $i, $item['participant']->name);
            $sheet->setCellValueByColumnAndRow($columnIndex + 3, $rowIndex + $i, $item['participant']->patronymic);
            $sheet->setCellValueByColumnAndRow($columnIndex + 4, $rowIndex + $i, $item['participant']->getSex());
            $sheet->setCellValueByColumnAndRow($columnIndex + 5, $rowIndex + $i, Yii::$app->formatter->asDate($item['participant']->birthdate, 'php:d.m.Y'));
            $sheet->setCellValueByColumnAndRow($columnIndex + 6, $rowIndex + $i, 'РФ');
            $sheet->setCellValueByColumnAndRow($columnIndex + 7, $rowIndex + $i, $item['participant']->getOVZ());
            $sheet->setCellValueByColumnAndRow($columnIndex + 8, $rowIndex + $i, $item['application']->participant->school->name);
            $sheet->setCellValueByColumnAndRow($columnIndex + 9, $rowIndex + $i, $item['category']->category . ' ' . 'класс');
            $sheet->setCellValueByColumnAndRow($columnIndex + 10, $rowIndex + $i, $item['application']->participant->class . ' ' . 'класс');
            $sheet->setCellValueByColumnAndRow($columnIndex + 11, $rowIndex + $i, $item['application']->getTotalScore());
            $sheet->setCellValueByColumnAndRow($columnIndex + 12, $rowIndex + $i, $item['application']->setStatus());
        }
    }
}