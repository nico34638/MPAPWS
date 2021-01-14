<?php


namespace App\Tests\Form;


use App\Entity\User;
use App\Form\ModifyProfilType;
use Symfony\Component\Form\Extension\Core\CoreExtension;
use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Class ModifProfilTypeTest
 * @package App\Tests\Form
 */
class ModifProfilTypeTest extends TypeTestCase
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
     * Test form modif profil
     */
    public function test_modify_profil_type()
    {;

        $formData = [
            'firstName' => 'test',
            'lastName' => 'test',
            'username' => 'test',
            'email' => 'test@gmail.com',
            'password.first' => 'test',
            'password.second' => 'test',
            'address' => 'rue de l\'example'
        ];

        $expected = new User();
        $expected->setFirstName('test');
        $expected->setLastName('test');
        $expected->setUsername('test');
        $expected->setEmail('test@gmail.com');
        $expected->setAddress('rue de l\'example');

        $contentForm = new User();

        $form = $this->factory->create(ModifyProfilType::class, $contentForm);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $contentForm);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            if($key!='password.first' and $key!='password.second'){
                $this->assertArrayHasKey($key, $children);
            }
        }
    }

}
