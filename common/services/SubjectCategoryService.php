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
        $subjectCategory = $this->subjectCategoryRepository->get($subjectCategoryId);
        $applications = $this->applicationRepository->getBySubjectCode($subjectCategory->subject->subject_code);
        foreach ($applications as $application){
            $item = [
                'application' => $application,
                'participant' => $application->participant,
                'category' => $application->subjectCategory,
                'appearance' => $application->appearances,
                'taskApplications' => $application->taskApplications
            ];
            $data[] = $item;
        }
        return ['data' => $data, 'subject_code' => $subjectCategory->subject->subject_code];
    }
}