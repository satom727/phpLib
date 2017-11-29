<?php

class ColumnMetaData
{
    // private $declType;
    private $nativeType;
    private $flags;
    private $name;
    private $table;
    private $len;
    private $precision;
    private $pdoType;

    function __construct($pdoMeta) {
        // $declType = $pdoMeta['decl_type'];
        $nativeType = $pdoMeta['native_type'];
        $flags = $pdoMeta['flags'];
        $name = $pdoMeta['name'];
        $table = $pdoMeta['table'];
        $len = $pdoMeta['len'];
        $precision = $pdoMeta['precision'];
        $pdoType = $pdoMeta['pdo_type'];
    }
}
