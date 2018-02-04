<?php

class Legacy2018TemplateOperators extends eZTemplateAttributeOperator
{
    function __construct()
    {
    }

    function operatorList()
    {
        return array( 'attribute' );
    }

    function namedParameterList()
    {
        return array(
            'attribute' => array(
                "show_values" => array(
                    "type" => "string",
                    "required" => false,
                    "default" => ""
                ),
                "max_val"     => array(
                    "type" => "numerical",
                    "required" => false,
                    "default" => 2
                ),
                "format"      => array(
                    "type" => "boolean",
                    "required" => false,
                    "default" => eZINI::instance( 'template.ini' )->variable( 'AttributeOperator', 'DefaultFormatter' )
                )
            ),
        );
    }

    function operatorTemplateHints()
    {
        return array(
            'attribute' => array(
                'input' => true,
                'output' => true,
                'parameters' => 3,
            ),
        );
    }

    function namedParameterPerOperator()
    {
        return true;
    }
}
