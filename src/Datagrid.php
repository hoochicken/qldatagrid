<?php

namespace Hoochicken\Datagrid;

class Datagrid
{

    private array $columns = [];
    private array $rows = [];

    const TABLE = '<table>{thead}{tbody}</thead>';
    const THEAD = '<thead><tr>{content}</tr></thead>';
    const TBODY = '<tbody><tr>{content}</tr></tbody>';
    const TR = '<tr>{content}</tr>';
    const TD = '<td>{content}</td>';
    const TH = '<th>{content}</th>';


    public function getTable(array $data, array $columns = []): string
    {
        if (0 === count($data)) return '';
        if (0 === count($columns)) {
            $columns = $this->getDefaultColumns($data[0] ?? []);
        }

        $html = self::TABLE;
        $html = str_replace('{thead}', $this->getTHead($columns), $html);
        $html = str_replace('{tbody}', $this->getTBody($data), $html);
        return $html;
    }

    public function getDefaultColumns(array $firstRow): array
    {
        $columns = [];
        foreach ($firstRow as $column => $content) {
            $columns[$column] = $column;
        }
        return $columns;
    }

    public function getThead(array $columns): string
    {
        return $this->getTr($columns, true);
    }

    public function getTBody(array $data): string
    {
        $rows = [];
        foreach ($data as $row) {
            $rows[] = $this->getTr($row);
        }
        return str_replace('{content}', $this->concatTags($rows), self::TBODY);
    }

    public function getCell($content, bool $th = false, string $class = ''): string
    {
        $cell = $th ? self::TH : self::TD;
        return str_replace('{content}', $content, $cell);
    }

    public function getTr(array $row, bool $th = false): string
    {
        $cells = [];
        foreach ($row as $column => $label) {
            $cells[] = $this->getCell($label, $th, $column);
        }
        return str_replace('{content}', $this->concatTags($cells) ,self::THEAD);
    }
    public function concatTags(array $tags): string
    {
        return implode("\n", $tags);
    }
}
