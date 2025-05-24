<?php
namespace frontend\components;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;
use yii\web\Response;

class ExcelCreator
{
    /*
        структура констант предметов:
        [путь к шаблону, стартовая клетка,[игнорируемые клетки], возрастные категории]
    */
    public const MATH = [
        'filepath' => '/templates/math.xlsx',
        'participantCell' => 'A1',
        'codeCell' => 'B1',
        'pointCell' => 'C1',
        'ignoreCell' => ['D1'],
    ];
    public const RUSSIAN = [];
    public const HISTORY = [];
    public static function createForm($data)
    {
        $templatePath = Yii::$app->basePath . self::MATH['filepath'];
        if (!file_exists($templatePath)) {
            throw new \Exception('Шаблонный файл не найден');
        }
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Заголовок формы');
        $outputFilename = 'ВСОШ_' . date('Ymd_His') . '.xlsx';
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