<?php


namespace App\Tests\Form;


use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Component\Form\Test\TypeTestCase;

class RegisterTypeTest extends TypeTestCase
{

    public function test_register_type()
    {
        $formData = [
            'prenom' => 'test',
            'nom' => 'test',
            'username' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'test',
            'password' => 'test',
            'roles' => [],
            'activation_token' => null,
            'reset_token' => null
        ];

        $expected = new User();
        $expected->setPassword("test");
        $expected->setPrenom('test');
        $expected->setNom('test');
        $expected->setEmail('test@gmail.com');
        $expected->setUsername('test');
        $expected->setRoles([]);

        $contentForm = new User();

        $form = $this->factory->create(RegisterType::class, $contentForm);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());


    }

}