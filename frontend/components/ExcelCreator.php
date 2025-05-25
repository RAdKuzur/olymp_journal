<?php
namespace frontend\components;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;
use yii\web\Response;

class ExcelCreator
{
    /*
        структура констант предметов:
        [путь к шаблону, стартовая клетка,[игнорируемые клетки], возрастные категории]
    */
    public const SUBJECT = [
        'MATH' => [
            'filepath' => '/templates/math.xlsx',
            'participantCell' => ['A', 1],
            'codeCell' => ['B', 1],
            'pointCell' => ['C', 1],
            'ignoreColumns' => ['F'],
        ]
    ];
    public static function createForm($data)
    {
        $templatePath = Yii::$app->basePath . self::SUBJECT[$data['subject_code']]['filepath'];
        if (!file_exists($templatePath)) {
            throw new \Exception('Шаблонный файл не найден');
        }
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();
        foreach ($data['data'] as $i => $item) {
            //participant
            $sheet-> setCellValue(
                self::SUBJECT[$data['subject_code']]['participantCell'][0] .
                (self::SUBJECT[$data['subject_code']]['participantCell'][1] + $i),
                $item['fio']
            );
            //codes
            $sheet->setCellValue(
                self::SUBJECT[$data['subject_code']]['codeCell'][0] .
                (self::SUBJECT[$data['subject_code']]['codeCell'][1] + $i),
                $item['code']
            );
            //points
            foreach($item['taskApplications'] as $counter => $taskApplication) {
                $columnIndex = Coordinate::columnIndexFromString(self::SUBJECT[$data['subject_code']]['pointCell'][0]);
                $sheet->setCellValueByColumnAndRow($columnIndex + $counter, $i + self::SUBJECT[$data['subject_code']]['pointCell'][1], $taskApplication->points);
            }
        }
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
}