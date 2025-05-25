<?php

namespace common\services;

use common\repositories\ApplicationRepository;
use common\repositories\SubjectCategoryRepository;
use frontend\models\olymp\Application;

class SubjectCategoryService
{
    private ApplicationRepository $applicationRepository;
    private SubjectCategoryRepository $subjectCategoryRepository;
    public function __construct(
        ApplicationRepository $applicationRepository,
        SubjectCategoryRepository $subjectCategoryRepository
    )
    {
        $this->applicationRepository = $applicationRepository;
        $this->subjectCategoryRepository = $subjectCategoryRepository;
    }

    public function prepareData($subjectCategoryId){
        /** @var Application $application */
        $data = [];
        $applications = $this->applicationRepository->getBySubjectCategoryId($subjectCategoryId);
        $subjectCategory = $this->subjectCategoryRepository->get($subjectCategoryId);
        foreach ($applications as $application){
            $item = [
                'fio' => $application->participant->getFullFio(),
                'category' => $application->subjectCategory->category,
                'code' => $application->code,
                'appearance' => $application->appearances,
                'taskApplications' => $application->taskApplications
            ];
            $data[] = $item;
        }
        return ['data' => $data, 'subject_code' => $subjectCategory->subject->subject_code];
    }
}