<?php
namespace R794021\DataFile;

class DataTable
{
    protected array $headers;
    protected array $rows;

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

    public function addFakeData(array $fakeItems = []): void
    {
        foreach($fakeItems as $header => $boundary) {
            if (in_array($header, $this->headers)) {
                continue;
            }
            $this->headers[] = $header;
            $this->rows = \array_map(function ($row) use ($boundary) {
                $newValue = \rand(1, $boundary);
                return \array_merge($row, [$newValue]);
            }, $this->rows);
        };
    }
}
