<?php


namespace App\Tests\Unit;


use App\Entity\Logs\AuditShippingOrder;
use App\Entity\ShippingOrder\OrderStatus;
use App\Entity\ShippingOrder\ShippingOrder;
use App\Factory\Log\AuditShippingOrderFactory;
use PHPUnit\Framework\TestCase;

class UnitTest extends TestCase
{
    //(Magic Method) run before every test
    public function setup(): void
    {

    }
    //(Magic Method) called once for the entire class
    public static function setUpBeforeClass(): void
    {

    }



    public function testShippingOrderFactory()
    {
        //We have to mock it because it's in the database
        $status = $this->createMock(OrderStatus::class);
        $status->expects($this->any())->method('getName')->willReturn('Test');
        $status->expects($this->any())->method('getId')->willReturn(6);

        $shippingOrder = new ShippingOrder();
        $shippingOrder->setOrderId(100);
        $shippingOrder->setDiscount(50);
        $shippingOrder->setShippingCompany('C1');
        $shippingOrder->setTotal(33);
        $shippingOrder->setStatus($status);
        $shippingOrder->setShippingDetails("This is details");
        $shippingOrder->setShippingTrackingNumber('12345678');

        $audit = AuditShippingOrderFactory::create($shippingOrder);
        $this->assertInstanceOf(AuditShippingOrder::class, $audit);
        $this->assertSame($shippingOrder->getOrderId(), $audit->getOrderId());
        $this->assertSame($shippingOrder->getStatus()->getName(), $audit->getStatusName());
        $this->assertSame($shippingOrder->getStatus()->getId(), $audit->getStatusId());
        $this->assertSame($shippingOrder->getDiscount(), $audit->getDiscount());
        $this->assertSame($shippingOrder->getShippingDetails(), $audit->getShippingDetails());
        $this->assertSame($shippingOrder->getTotal(), $audit->getTotal());
        $this->assertSame($shippingOrder->getShippingCompany(), $audit->getShippingCompany());
        $this->assertSame($shippingOrder->getShippingTrackingNumber(), $audit->getShippingTrackingNumber());
    }
}