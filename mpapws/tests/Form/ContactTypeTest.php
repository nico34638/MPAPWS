<?php


namespace App\Tests\Form;


use App\Entity\Message;
use App\Form\ContactType;
use Symfony\Component\Form\Extension\Core\CoreExtension;
use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;

class ContactTypeTest extends TypeTestCase
{
    /**
     * Setup function fix validator problem
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
     * Test form contact
     */
    public function test_contact_type()
    {
        $formData = [
            'email' => 'test',
            'object' => 'test',
            'text' => 'test',
        ];

        $expected = new Message();
        $expected->setText('test');
        $expected->setObject('test');
        $expected->setEmail('test');

        $contentForm = new Message();

        $form = $this->factory->create(ContactType::class, $contentForm);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $contentForm);

    }
}