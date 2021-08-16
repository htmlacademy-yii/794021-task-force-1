<?php
namespace R794021\DataFile;

class DataTable
{
    protected array $fields;
    protected array $map;
    protected array $mappedFields = [];

    public function __construct(array $headers = [], $rows = [])
    {
        $this->headers = $headers;
        $this->rows = $rows;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getRows(): array
    {
        return $this->rows;
    }

    public function changeHeaders(array $newHeaders): void
    {
        $this->headers = array_map(function ($header) use ($newHeaders) {
            return \array_key_exists($header, $newHeaders) ?
                $newHeaders[$header] :
                $header;
        }, $this->headers);
    }

    public function generate(array $fakeItems = []): void
    {
        foreach($fakeItems as $header => $boundary) {
            if ( in_array($header, $this->headers) ) {
                continue;
            }
            $this->headers[] = $header;
            $this->rows = array_map(function($row) use ($boundary) {
                $row[] = rand(1, $boundary);
                return $row;
            }, $this->rows);
        };
    }
}
