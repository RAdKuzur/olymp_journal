<?php

namespace common\services;

use common\repositories\ApplicationRepository;
use frontend\models\olymp\Application;

class SubjectCategoryService
{
    private ApplicationRepository $applicationRepository;
    public function __construct(
        ApplicationRepository $applicationRepository
    )
    {
        $this->applicationRepository = $applicationRepository;
    }

    public function prepareData($subjectCategoryId){
        /** @var Application $application */
        $data = [];
        $applications = $this->applicationRepository->getBySubjectCategoryId($subjectCategoryId);
        foreach ($applications as $application){
            $item = [
                'fio' => $application->participant->getFullFio(),
                'code' => $application->code,
                'appearance' => $application->appearances,
                'taskApplications' => $application->taskApplications
            ];
            $data[] = $item;
        }
        return $data;
    }
}