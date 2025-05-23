<?php
namespace common\services;
use common\repositories\AppearanceRepository;
use common\repositories\ApplicationRepository;
use frontend\models\olymp\Appearance;

class AppearanceService
{
    private ApplicationRepository $applicationRepository;
    private AppearanceRepository $appearanceRepository;
    public function __construct(
        ApplicationRepository $applicationRepository,
        AppearanceRepository $appearanceRepository
    )
    {
        $this->applicationRepository = $applicationRepository;
        $this->appearanceRepository = $appearanceRepository;
    }

    public function createAppearance($subjectCategoryId)
    {
        $applications = $this->applicationRepository->getBySubjectCategoryId($subjectCategoryId);
        foreach ($applications as $application) {
            if(!$this->appearanceRepository->checkUnique($application->id)) {
                $this->appearanceRepository->create($application->id, Appearance::NON_APPEARANCE, 1);
            }
        }
    }
}