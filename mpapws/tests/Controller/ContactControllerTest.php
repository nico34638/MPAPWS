<?php


namespace App\Tests\Controller;


use App\Domain\Command\ContactFormCommand;
use App\Entity\Message;
use App\Form\ContactType;
use Symfony\Component\Form\Test\TypeTestCase;

class ContactControllerTest extends TypeTestCase
{
    public function test_contact_form()
    {;
        $formData = [
            'email' => 'test@test.test',
            'object' => 'test',
            'text' => 'test'
        ];

        $expected = new Message();
        $expected->setEmail('test@test.test');
        $expected->setObject('test');
        $expected->setText('test');

        $contentForm = new Message();

        $form = $this->factory->create(ContactType::class, $contentForm);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $contentForm);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}