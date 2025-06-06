<?php

namespace frontend\controllers;



use common\components\AuthComponent;
use common\components\RedisComponent;
use common\repositories\SubjectCategoryRepository;
use common\repositories\TaskApplicationRepository;
use common\repositories\TaskRepository;
use common\services\ErrorService;
use common\services\SubjectCategoryService;
use common\services\TaskApplicationService;
use common\services\TaskService;
use frontend\components\ExcelCreator;
use frontend\models\olymp\Task;
use frontend\models\olymp\TaskApplication;
use PhpAmqpLib\Message\AMQPMessage;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\BaseArrayHelper;

class SubjectCategoryController extends \yii\web\Controller
{
    private SubjectCategoryRepository $subjectCategoryRepository;
    private TaskRepository $taskRepository;
    private TaskService $taskService;
    private TaskApplicationRepository $taskApplicationRepository;
    private TaskApplicationService $taskApplicationService;
    private ErrorService $errorService;
    private SubjectCategoryService $subjectCategoryService;
    public function __construct(
        $id,
        $module,
        SubjectCategoryRepository $subjectCategoryRepository,
        TaskRepository $taskRepository,
        TaskService $taskService,
        TaskApplicationRepository $taskApplicationRepository,
        TaskApplicationService $taskApplicationService,
        ErrorService $errorService,
        SubjectCategoryService $subjectCategoryService,
        $config = []
    )
    {
        $this->subjectCategoryRepository = $subjectCategoryRepository;
        $this->taskRepository = $taskRepository;
        $this->taskService = $taskService;
        $this->taskApplicationRepository = $taskApplicationRepository;
        $this->taskApplicationService = $taskApplicationService;
        $this->errorService = $errorService;
        $this->subjectCategoryService = $subjectCategoryService;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(){
        $subjectCategories = $this->subjectCategoryRepository->getAllQuery();
        return $this->render('index', [
                'subjectCategories' => new ActiveDataProvider([
                    'query' => $subjectCategories
                ])
            ]
        );
    }
    public function actionView($id){
        $model = $this->subjectCategoryRepository->get($id);
        return $this->render('view', [
            'model' => $model
        ]);
    }
    public function actionUpdate($id){
        Yii::$app->session->setFlash('danger', 'Для изменения обратитесь к разработчику');
        return $this->redirect(['index']);
    }
    public function actionDelete($id){
        Yii::$app->session->setFlash('danger', 'Для удаления обратитесь к разработчику');
        return $this->redirect(['index']);
    }
    public function actionTasks($id){
        $tasks = $this->taskRepository->getBySubjectCategoryId($id);
        $models = [new Task()];
        $post = Yii::$app->request->post();
        if(Yii::$app->request->post()){
            $this->taskService->createTasks($post['Task'], $id);
            return $this->redirect(['view', 'id' => $id]);
        }
        return $this->render('tasks', [
            'tasks' => $tasks,
            'models' => $models
        ]);
    }
    public function actionDeleteTask($id){
        $task = $this->taskRepository->get($id);
        $this->taskService->delete($id);
        return $this->redirect(['tasks', 'id' => $task->subject_category_id]);
    }
    public function actionJournal($id) {
        $this->errorService->checkError($id, ErrorService::JOURNAL_TYPE_ERROR);
        $taskApplications = $this->taskApplicationRepository->getBySubjectCategoryId($id);
        $dataProvider = $this->taskApplicationService->prepareJournalDataProvider($taskApplications);
        return $this->render('journal', [
            'dataProvider' => $dataProvider,
            'tasks' => $this->taskService->getUniqueTasks($taskApplications),
            'id' => $id
        ]);
    }
    public function actionCreateJournal($id){
        $this->taskApplicationService->create($id);
        return $this->redirect(['journal', 'id' => $id]);
    }
    public function actionUpdatePoints($id)
    {
        /* @var TaskApplication $model */
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $applicationId = Yii::$app->request->post('application_id');
        $taskId = Yii::$app->request->post('task_id');
        $points = Yii::$app->request->post('points');

        $model = $this->taskApplicationRepository->getByTaskAndApplicationId($applicationId, $taskId);
        $this->taskApplicationRepository->changeScore($model, $points);
        $this->taskApplicationRepository->save($model);
    }
    public function actionDownload($id)
    {
        try {
            if(!$this->errorService->checkError($id, ErrorService::JOURNAL_TYPE_ERROR) && !$this->errorService->checkError($id, ErrorService::APPEARANCE_TYPE_ERROR)){
                $data = $this->subjectCategoryService->prepareData($id);
                return ExcelCreator::createForm($data);
            }
            return $this->redirect(['view', 'id' => $id]);
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(['index']);
        }
    }
    public function beforeAction($action){

        if (AuthComponent::isGuest()){
            return $this->redirect('index.php?r=site/login');
        }
        return parent::beforeAction($action);
    }
}