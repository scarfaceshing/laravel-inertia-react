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

 public const SEX = [
  self::MALE,
  self::FEMALE
 ];

 public const REGULARIZATION = [
  self::REGULAR,
  self::PROBITIONARY
 ];

 public const CIVIL_STATUS = [
  self::SINGLE,
  self::WIDOWED,
  self::MARRIED
 ];
}
