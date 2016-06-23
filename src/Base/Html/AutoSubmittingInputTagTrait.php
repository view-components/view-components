<?php

namespace ViewComponents\ViewComponents\Base\Html;

trait AutoSubmittingInputTagTrait
{
    use AutoSubmittingInputTrait;

    private static $onChangeScript = 'this.form.submit()';

    abstract public function getAttribute($name, $default = null);

    abstract public function setAttribute($name, $value);

    protected function onAutoSubmittingValueChange()
    {
        $onChange = $this->getAttribute('onchange', null);
        if ($this->isAutoSubmitted()) {
            if ($onChange === null) {
                $this->setAttribute('onchange', self::$onChangeScript);
            } elseif (strpos($onChange, self::$onChangeScript) === false) {
                $this->setAttribute('onchange', $onChange . ';' . self::$onChangeScript);
            }
        } else {
            if ($onChange !== null) {
                if ($onChange === self::$onChangeScript) {
                    $this->setAttribute('onchange', null);
                } else {
                    $this->setAttribute('onchange', str_replace(self::$onChangeScript, '', $onChange));
                }
            }
        }
    }
}
