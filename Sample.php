<?php

class Sample extends Api
{
    protected function getAction()
    {
        return ["field1" => "Hello", "field2" => "world!!"];
    }
}