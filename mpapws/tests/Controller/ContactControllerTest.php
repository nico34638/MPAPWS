<?php


namespace App\Tests\Controller;


use Symfony\Component\Form\Test\TypeTestCase;

class ContactControllerTest extends TypeTestCase
{
    public function test_contact_form(){
        $formData = [
            'object' => 'test',
            'email' => 'test@test.test',
            'text' => 'test'
        ];
    }
}