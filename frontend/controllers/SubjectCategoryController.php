<?php

namespace frontend\controllers;



use common\repositories\SubjectCategoryRepository;
use common\repositories\TaskRepository;
use common\services\TaskService;
use frontend\models\olymp\Task;
use Yii;
use yii\data\ActiveDataProvider;

class SubjectCategoryController extends \yii\web\Controller
{
    private SubjectCategoryRepository $subjectCategoryRepository;
    private TaskRepository $taskRepository;
    private TaskService $taskService;
    public function __construct(
        $id,
        $module,
        SubjectCategoryRepository $subjectCategoryRepository,
        TaskRepository $taskRepository,
        TaskService $taskService,
        $config = []
    )
    {
        $this->subjectCategoryRepository = $subjectCategoryRepository;
        $this->taskRepository = $taskRepository;
        $this->taskService = $taskService;
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
    public function actionCreate(){}
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
    public function actionJournal($id){

    }
}