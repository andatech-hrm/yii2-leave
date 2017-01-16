<?php
namespace andahrm\leave\base;

use Yii;



class YearConverter  extends \yii\base\Behavior{
  
  /**
     * @var array Attribute map for logical to physical
     */
    public $attributes = [];
  
    public function __get($name)
    {
        if (isset($this->attributes[$name])) {
            $attrValue = $this->owner->{$this->attributes[$name]};
            return $this->convertToLogical($attrValue, $name);
        } else {
            return parent::__get($name);
        }
    }
    /**
     * @inheritdoc
     */
    public function __set($name, $value)
    {
        if (isset($this->attributes[$name])) {
            $this->owner->{$this->attributes[$name]} = $this->convertToPhysical($value, $name);
        } else {
            parent::__set($name, $value);
        }
    }

  public function convertToPhysical($value, $attribute)
    {
         return $value+543;
    }
    /**
     * Convert value to logical format
     * @param mixed $value value to converted
     * @param string $attribute Logical attribute
     * @return mixed Converted value
     */
    public function convertToLogical($value, $attribute)
    {
        return $value+11;
    }
  
  
}