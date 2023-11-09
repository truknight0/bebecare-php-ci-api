<?php


namespace App\Libraries\Common;


use Karriere\JsonDecoder\Exceptions\InvalidBindingException;
use Karriere\JsonDecoder\Exceptions\InvalidJsonException;
use Karriere\JsonDecoder\Exceptions\JsonValueException;
use Karriere\JsonDecoder\Exceptions\NotExistingRootException;
use Karriere\JsonDecoder\JsonDecoder;

class Gson
{
    public static function fromJson(string $classType, string $jsonString, bool $isMultiple = false)
    {
        $jsonDecoder = new JsonDecoder();
        $jsonDecoder->scanAndRegister($classType);

        try {
            if ($isMultiple) {
                return $jsonDecoder->decodeMultiple($jsonString, $classType);
            } else {
                return $jsonDecoder->decode($jsonString, $classType);
            }
        } catch (InvalidBindingException | InvalidJsonException | JsonValueException | NotExistingRootException $e) {
            return null;
        }
    }

    public static function fromJson2($object, $jsonString)
    {
        \PHPGson2\Gson::fromJson($object, $jsonString);
        return $object;
    }
}