<?php

namespace Icetig\Bundle\ApiBundle\Entity;
use Icetig\Bundle\ApiBundle\Exception\IncorrectPropertyException;

/**
 * AbstractApiEntity
 */
class AbstractApiEntity
{
    /**
     * TODO make it cool (append to Array, foreign keys, etc...)
     *
     * @param string $property
     * @param $value
     *
     * @throws IncorrectPropertyException
     */
    private function updateProperty(string $property, $value)
    {
        $setter = 'set' . ucfirst($property);

        if (method_exists($this, $setter))
            try {
                $this->$setter($value);
            } catch (\Exception $e) {
                throw new IncorrectPropertyException("Incorrect property: ". $property);
            }
    }

    /**
     * @param array $parameters
     *
     * @throws IncorrectPropertyException
     */
    public function update(array $parameters = [])
    {
        foreach (array_keys($parameters) as $property)
            if (property_exists($this, $property))
                $this->updateProperty($property, $parameters[$property]);
    }

    /**
     * @param string $property
     * @return mixed
     * @throws IncorrectPropertyException
     */
    public function getPropertyData(string $property)
    {
        $getter = 'get' . ucfirst($property);

        if (method_exists($this, $getter))
            return $this->$getter();
        throw new IncorrectPropertyException("Incorrect property: ". $property);
    }

    /**
     * @param array $properties
     * @return array
     * @throws IncorrectPropertyException
     */
    public function getPropertiesData(array $properties = [])
    {
        $data = [];
        foreach ($properties as $property) {
            $data[$property] = $this->getPropertyData($property);
        }
        return $data;
    }
}
