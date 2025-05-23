<?php

namespace common\services;


use common\repositories\AppearanceRepository;
use common\repositories\TaskApplicationRepository;
use common\repositories\TaskRepository;
use frontend\models\olymp\Appearance;
use frontend\models\olymp\Task;
use yii\data\ArrayDataProvider;

class TaskApplicationService
{
    private TaskApplicationRepository $taskApplicationRepository;
    private TaskRepository $taskRepository;
    private AppearanceRepository $appearanceRepository;
    public function __construct(
        TaskApplicationRepository $taskApplicationRepository,
        TaskRepository $taskRepository,
        AppearanceRepository $appearanceRepository

    )
    {
        $this->taskApplicationRepository = $taskApplicationRepository;
        $this->taskRepository = $taskRepository;
        $this->appearanceRepository = $appearanceRepository;
    }

    public function create($subjectCategoryId)
    {
        /* @var Task $task */
        /* @var Appearance $appearance */
        $tasks = $this->taskRepository->getBySubjectCategoryId($subjectCategoryId);
        $appearances = $this->appearanceRepository->getAppearancesBySubjectCategoryId($subjectCategoryId);
        foreach ($tasks as $task) {
            foreach ($appearances as $appearance) {
                if(!$this->taskApplicationRepository->checkUnique($appearance->application->id, $task->id)){
                    $this->taskApplicationRepository->create($appearance->application->id, $task->id);
                }
            }
        }
    }

    public function prepareJournalDataProvider($taskApplications) {
        // Группируем по application_id
        $groupedData = [];
        foreach ($taskApplications as $item) {
            $appId = $item->application_id;
            if (!isset($groupedData[$appId])) {
                $groupedData[$appId] = [
                    'application_id' => $appId,
                    'application' => $item->application, // если нужно использовать связанные данные
                ];
            }
            $groupedData[$appId]['task_' . $item->task_id] = $item->points;
        }

        return new ArrayDataProvider([
            'allModels' => array_values($groupedData),
            'pagination' => false,
        ]);
    }

}