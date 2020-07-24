<?php

namespace App\DataFixtures;

use App\Entity\Coupon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CouponFixtures extends Fixture
{
    private $coupons = [
        [
            "code" => "1234",
            "description" => "universal coupon code",
            "discount" => 0.15
        ],
        [
            "code" => "abcd",
            "description" => "universal coupon code",
            "discount" => 0.15
        ],
        [
            "code" => "abcd1234",
            "description" => "universal coupon code",
            "discount" => 0.15
        ]
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->coupons as $coupon) {
            $newCoupon = new Coupon();
            $newCoupon->setCode($coupon["code"]);
            $newCoupon->setDescription($coupon["description"]);
            $newCoupon->setDiscount($coupon["discount"]);
            $manager->persist($newCoupon);
        }

        $manager->flush();
    }
}
