<?php
namespace R794021\DataFile;

class SQLInsertMaker
{
    private function __construct()
    {
    }

    public static function make(
        string $tablename, array $headers, array $rows
    ): string
    {
        $result = '';
        $headersSection = implode(', ', $headers);
        foreach($rows as $values) {
            $values = array_map(function ($value) {
                return "\"$value\"";
            }, $values);
            $valuesSection = implode(', ', $values);

            $result .=
                "INSERT INTO $tablename ($headersSection) " .
                "VALUES ($valuesSection);" . PHP_EOL;
        }
        return $result;
    }
}
