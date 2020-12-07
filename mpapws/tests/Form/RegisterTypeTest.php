<?php


namespace App\Tests\Form;


use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class RegisterTypeTest
 * @package App\Tests\Form
 */
class RegisterTypeTest extends TypeTestCase
{

    /**
     * Test form register
     */
    public function test_register_type()
    {
        $formData = [
            'prenom' => 'test',
            'nom' => 'test',
            'username' => 'test',
            'email' => 'test@gmail.com',
            'password.first' => 'test',
            'password.second' => 'test'
        ];

        $expected = new User();
        $expected->setPrenom('test');
        $expected->setNom('test');
        $expected->setUsername('test');
        $expected->setEmail('test@gmail.com');

        $contentForm = new User();

        $form = $this->factory->create(RegisterType::class, $contentForm);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $contentForm);

    }

}