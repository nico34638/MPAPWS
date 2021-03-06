<?php


namespace App\Tests\Form;


use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\Form\Extension\Core\CoreExtension;
use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;

class ProductTypeTest extends TypeTestCase
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