<?php
namespace R794021\DataFile;

class CSVImporter
{
    protected \SplFileObject $file;
    protected string $filename;
    protected array $headers;
    protected array $rows;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
        if (!\is_readable($filename) || !\is_file($filename)) {
            throw new \Exception("File '$filename' cannot be opened");
        }
        $this->file = new \SplFileObject($this->filename, 'r');
        $this->setOptions();
        $this->readHeader();
        $this->readBody();
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getRows(): array
    {
        return $this->rows;
    }

    protected function readBody(): void
    {
        while (!$this->file->eof()) {
            $fields = $this->file->fgetcsv();
            if (!$fields || !count($fields)) {
                continue;
            }
            $this->rows[] = $fields;
        }
    }

    protected function readHeader(): void
    {
        $this->headers = $this->file->fgetcsv();
    }

    protected function setOptions(): void
    {
        $this->file->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        $this->file->setCsvControl(',', '"', '');
    }
}
