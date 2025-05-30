<?php
namespace frontend\tests\models;

use common\components\Dictionary;
use frontend\models\olymp\Participant;

class ParticipantTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    protected function _before() {}
    protected function _after() {}

    public function testValidationFailsWhenRequiredFieldsAreMissing()
    {
        $participant = new Participant();
        $this->assertFalse($participant->validate(), 'Model should not validate when required fields are missing');
    }

    public function testValidationPassesWithValidData()
    {
        $participant = new Participant([
            'surname' => 'Иванов',
            'name' => 'Иван',
            'patronymic' => 'Иванович',
            'phone_number' => '+79001112233',
            'sex' => Dictionary::MALE,
            'birthdate' => '2005-05-05',
            'citizenship' => 1,
            'school_id' => 1, // Важно: school_id должен существовать в БД, иначе будет ошибка!
            'disability' => Dictionary::HEALTHY,
            'class' => 10,
        ]);

        // Отключаем проверку внешнего ключа, если тестовая БД пустая
        $participant->detachBehavior('existValidator');

        $this->assertTrue($participant->validate(), 'Model should validate with all required fields');
    }

    public function testGetFullFio()
    {
        $participant = new Participant([
            'surname' => 'Иванов',
            'name' => 'Иван',
            'patronymic' => 'Иванович',
        ]);

        $this->assertEquals('Иванов Иван Иванович', $participant->getFullFio());
    }

    public function testGetGender()
    {
        $participantMale = new Participant(['sex' => Dictionary::MALE]);
        $this->assertEquals('Мужской', $participantMale->getGender());

        $participantFemale = new Participant(['sex' => Dictionary::FEMALE]);
        $this->assertEquals('Женский', $participantFemale->getGender());
    }

    public function testGetOvz()
    {
        $participantHealthy = new Participant(['disability' => Dictionary::HEALTHY]);
        $this->assertEquals('Нет ОВЗ', $participantHealthy->getOvz());

        $participantDisabled = new Participant(['disability' => Dictionary::DISABILITY]);
        $this->assertEquals('Есть ОВЗ', $participantDisabled->getOvz());
    }
}