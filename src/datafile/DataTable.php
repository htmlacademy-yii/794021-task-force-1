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

    public function renameHeaders(array $mapHeaders): void
    {
        $this->headers = \array_map(function ($header) use ($mapHeaders) {
            if (! \array_key_exists($header, $mapHeaders)) {
                return $header;
            }
            $renamedHeader = $mapHeaders[$header];
            return $renamedHeader;
        }, $this->headers);
    }

    public function addFakeData(array $fakeItems = []): void
    {
        foreach($fakeItems as $header => $maxLimit) {
            if (\in_array($header, $this->headers)) {
                continue;
            }
            $this->headers[] = $header;
            $this->rows = \array_map(function ($row) use ($maxLimit) {
                $generatedValue = \rand(1, $maxLimit);
                return \array_merge($row, [$generatedValue]);
            }, $this->rows);
        };
    }
}
