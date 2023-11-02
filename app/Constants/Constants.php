<?php

declare(strict_types=1);

namespace App\Constants;

class Constants
{
 public const MALE = 'MALE';
 public const FEMALE = 'FEMALE';
 public const REGULAR = 'REGULAR';
 public const PROBITIONARY = 'PROBITIONARY';
 public const SINGLE = 'SINGLE';
 public const WIDOWED = 'WIDOWED';
 public const MARRIED = 'MARRIED';
 public const TERMINATE = 'TERMINATE';
 public const RESIGNED = 'RESIGNED';

 public const GENDER = [
     self::MALE,
     self::FEMALE,
 ];

 public const EMPLOYEE_STATUS = [
     self::REGULAR,
     self::PROBITIONARY,
     self::TERMINATE,
     self::RESIGNED
 ];

 public const CIVIL_STATUS = [
     self::SINGLE,
     self::WIDOWED,
     self::MARRIED,
 ];
}
