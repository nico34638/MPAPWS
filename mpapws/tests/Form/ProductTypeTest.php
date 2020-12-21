<?php


namespace App\Tests\Form;


use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\Form\Test\TypeTestCase;

class ProductTypeTest extends TypeTestCase
{
    /**
     * Test form add product
     */
    public function test_product_type()
    {
        $formData = [
            'name' => 'boulgour',
            'description' => 'un boulgour de qualite',
            'price' => 10
        ];

        $expected = new Product();
        $expected->setName('boulgour');
        $expected->setDescription('un boulgour de qualite');
        $expected->setPrice(10);

        $contentForm = new Product();

        $form = $this->factory->create(ProductType::class, $contentForm);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $contentForm);

    }
}