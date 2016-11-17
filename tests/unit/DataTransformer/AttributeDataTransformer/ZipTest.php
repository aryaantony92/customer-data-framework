<?php
/**
 * Created by PhpStorm.
 * User: mmoser
 * Date: 17.11.2016
 * Time: 11:46
 */

namespace CustomerManagementFramework\Testing\DataTransformer\AttributeDataTransformer;

class ZipTest extends \PHPUnit_Framework_TestCase
{

    public function testCorrectTransformationsDe()
    {
        $transfomer = new \CustomerManagementFramework\DataTransformer\AttributeDataTransformer\Zip\De();

        $tests = [
            '6125' => '06125',
            'D-6125' =>  '06125',
            'D-06125' =>  '06125',
            '24113 Molf' =>  '24113',
            'Molf' => 'Molf',
            '123456' => '123456',
        ];

        foreach($tests as $from => $to) {

            $result = $transfomer->transform($from);

            $this->assertEquals($to, $result);
        }
    }

    public function testCorrectTransformationsNl()
    {
        $transfomer = new \CustomerManagementFramework\DataTransformer\AttributeDataTransformer\Zip\Nl();

        $tests = [
            '1234ta' => '1234 TA',
            '1234ta City' => '1234 TA',
            '1234' => '1234',
            '1234t' => '1234T',
        ];

        foreach($tests as $from => $to) {

            $result = $transfomer->transform($from);

            $this->assertEquals($to, $result);
        }
    }

    public function testCorrectTransformationsAt()
    {
        $transfomer = new \CustomerManagementFramework\DataTransformer\AttributeDataTransformer\Zip\At();

        $tests = [
            '5733 Bramberg' => '5733',
            'A-5733' => '5733',
            '57333' => '57333',
            '5733 Mühlbach 1' => '5733',
        ];

        foreach($tests as $from => $to) {

            $result = $transfomer->transform($from);

            $this->assertEquals($to, $result);
        }
    }

    public function testCorrectTransformationsDk()
    {
        $transfomer = new \CustomerManagementFramework\DataTransformer\AttributeDataTransformer\Zip\Dk();

        $tests = [
            '1234 Test' => '1234',
            'DK-1234' => '1234',
            '12345' => '12345',
            '1234 Test 1' => '1234',
        ];

        foreach($tests as $from => $to) {

            $result = $transfomer->transform($from);

            $this->assertEquals($to, $result);
        }
    }

    public function testCorrectTransformationsBe()
    {
        $transfomer = new \CustomerManagementFramework\DataTransformer\AttributeDataTransformer\Zip\Be();

        $tests = [
            '1234 Test' => '1234',
            'DK-1234' => '1234',
            '12345' => '12345',
            '1234 Test 1' => '1234',
        ];

        foreach($tests as $from => $to) {

            $result = $transfomer->transform($from);

            $this->assertEquals($to, $result);
        }
    }

    public function testCorrectTransformationsRu()
    {
        $transfomer = new \CustomerManagementFramework\DataTransformer\AttributeDataTransformer\Zip\Ru();

        $tests = [
            '123456 Test' => '123456',
            'RU-123456' => '123456',
            '1234567' => '1234567',
            '123456 Test 1' => '123456',
        ];

        foreach($tests as $from => $to) {

            $result = $transfomer->transform($from);

            $this->assertEquals($to, $result);
        }
    }

}