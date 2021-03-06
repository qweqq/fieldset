<?php
/**
 * @package   Fuel\Fieldset
 * @version   2.0
 * @author    Fuel Development Team
 * @license   MIT License
 * @copyright 2010 - 2013 Fuel Development Team
 * @link      http://fuelphp.com
 */

namespace Fuel\Fieldset\Input;

/**
 * Tests for CheckboxGroup
 *
 * @package Fuel\Fieldset\Input
 * @author  Fuel Development Team
 */
class CheckboxGroupTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var CheckboxGroup
	 */
	protected $object;

	protected function setUp()
	{
		$this->object = new CheckboxGroup;
	}

	/**
	 * @covers Fuel\Fieldset\Input\CheckboxGroup::set
	 * @group  Fieldset
	 */
	public function testAddCheckboxes()
	{
		$checkbox = new Checkbox();
		$this->object[] = $checkbox;

		$this->assertEquals(
			[$checkbox],
			$this->object->getContents()
		);
	}

	/**
	 * @covers            Fuel\Fieldset\Input\CheckboxGroup::set
	 * @group             Fieldset
	 * @expectedException \InvalidArgumentException
	 */
	public function testAddInvalid()
	{
		$this->object[] = 'Fluebar';
	}

	/**
	 * @covers Fuel\Fieldset\Input\CheckboxGroup::setName
	 * @group  Fieldset
	 */
	public function testSetName()
	{
		$checkbox1 = new Checkbox();
		$checkbox2 = new Checkbox();

		$this->object[] = $checkbox1;
		$this->object[] = $checkbox2;

		$name = 'test';

		$this->object->setName($name);

		$this->assertEquals(
			$checkbox1->getName(),
			$name . '[]'
		);

		$this->assertEquals(
			$checkbox2->getName(),
			$name . '[]'
		);
	}

	/**
	 * @covers Fuel\Fieldset\Input\CheckboxGroup::setValue
	 * @covers Fuel\Fieldset\Input\CheckboxGroup::getValue
	 * @group  Fieldset
	 */
	public function testSetValue()
	{
		$checkbox1 = new Checkbox('', [], '1');
		$checkbox2 = new Checkbox('', [], '2');

		$this->object[] = $checkbox1;
		$this->object[] = $checkbox2;

		$this->object->setValue(1);

		$this->assertEquals(
			1,
			$this->object->getValue()
		);

		$this->assertTrue($checkbox1->isChecked());
		$this->assertFalse($checkbox2->isChecked());

		$this->object->setValue([1, 2]);

		$this->assertTrue($checkbox1->isChecked());
		$this->assertTrue($checkbox2->isChecked());

		$this->object->setValue([]);

		$this->assertFalse($checkbox1->isChecked());
		$this->assertFalse($checkbox2->isChecked());
	}

	/**
	 * @covers Fuel\Fieldset\Input\CheckboxGroup::fromArray
	 * @group  Fieldset
	 */
	public function testFromArray()
	{
		$config = [
			'name' => 'test',
			'_content' => [
				'1' => 'one',
				'2' => 'two',
			]
		];

		$object = CheckboxGroup::fromArray($config);

		// Check we have the right object
		$this->assertInstanceOf(
			'Fuel\Fieldset\Input\CheckboxGroup',
			$object
		);

		// Check we have the correct name
		$this->assertEquals(
			'test[]',
			$object->getName()
		);

		// Check we have the right content
		foreach ($object->getContents() as $checkbox)
		{
			$this->assertInstanceOf(
				'Fuel\Fieldset\Input\Checkbox',
				$checkbox
			);
		}
	}

}
