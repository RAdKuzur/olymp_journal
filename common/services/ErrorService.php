<?php

namespace common\services;

use common\repositories\AppearanceRepository;
use common\repositories\ApplicationRepository;
use common\repositories\TaskApplicationRepository;
use common\repositories\TaskRepository;
use Yii;

class ErrorService
{
    public const JOURNAL_TYPE_ERROR = 1;
    public const APPEARANCE_TYPE_ERROR = 2;
    private AppearanceRepository $appearanceRepository;
    private ApplicationRepository $applicationRepository;
    private TaskRepository $taskRepository;
    private TaskApplicationRepository $taskApplicationRepository;

    public function __construct(
        AppearanceRepository $appearanceRepository,
        ApplicationRepository $applicationRepository,
        TaskRepository $taskRepository,
        TaskApplicationRepository $taskApplicationRepository
    )
    {
        $this->appearanceRepository = $appearanceRepository;
        $this->applicationRepository = $applicationRepository;
        $this->taskRepository = $taskRepository;
        $this->taskApplicationRepository = $taskApplicationRepository;
    }

    public function checkError($subjectCategoryId, $type)
    {
        switch ($type) {
            case self::JOURNAL_TYPE_ERROR:
                if(count($this->appearanceRepository->getAppearancesBySubjectCategoryId($subjectCategoryId))
                    * count($this->taskRepository->getBySubjectCategoryId($subjectCategoryId)) !=
                    count($this->taskApplicationRepository->getBySubjectCategoryId($subjectCategoryId))
                ) {
                    Yii::$app->session->setFlash('danger', 'Количество присутствовавших участников не совпадает с количеством участников в разделе баллов');
                    return true;
                }
            case self::APPEARANCE_TYPE_ERROR:
                if(count($this->appearanceRepository->getBySubjectId($subjectCategoryId)) !=
                    count($this->applicationRepository->getBySubjectCategoryId($subjectCategoryId))) {
                    Yii::$app->session->setFlash('danger', 'Количество заявленных участников не совпадает с количеством участников в разделе явок');
                    return true;
                }
            default:
                break;
        }
        return false;
    }
}