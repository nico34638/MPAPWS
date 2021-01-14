<?php


namespace App\Tests\Form;


use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Component\Form\Extension\Core\CoreExtension;
use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Class RegisterTypeTest
 * @package App\Tests\Form
 */
class RegisterTypeTest extends TypeTestCase
{

    /**
     * Setup fonction fix validator problem
     */
    public function setUp(): void
    {
        parent::setUp();
        $validator = $this->createMock('\Symfony\Component\Validator\Validator\ValidatorInterface');
        $validator->method('validate')->will($this->returnValue(new ConstraintViolationList()));
        $formTypeExtension = new FormTypeValidatorExtension($validator);
        $coreExtension = new CoreExtension();

        $this->factory = Forms::createFormFactoryBuilder()
            ->addExtensions($this->getExtensions())
            ->addExtension($coreExtension)
            ->addTypeExtension($formTypeExtension)
            ->getFormFactory();
    }

    /**
     * Test form register
     */
    public function test_register_type()
    {
        $formData = [
            'firstName' => 'test',
            'lastName' => 'test',
            'username' => 'test',
            'email' => 'test@gmail.com',
            'password.first' => 'test',
            'password.second' => 'test'
        ];

        $expected = new User();
        $expected->setFirstName('test');
        $expected->setLastName('test');
        $expected->setUsername('test');
        $expected->setEmail('test@gmail.com');

        $contentForm = new User();

        $form = $this->factory->create(RegisterType::class, $contentForm);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $contentForm);

    }

}