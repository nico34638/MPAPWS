<?php


namespace App\Tests\Form;


use App\Entity\User;
use App\Form\RegisterType;
use App\Form\SearchType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class SearchTypeTest
 * @package App\Tests\Form
 */
class SearchTypeTest extends TypeTestCase
{
    /**
     * Test form search
     */
    public function test_search_type()
    {
        $formData = [
            'content' => 'test'
        ];

        $form = $this->factory->create(SearchType::class);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($form->getData()["content"], "test");

    }
}