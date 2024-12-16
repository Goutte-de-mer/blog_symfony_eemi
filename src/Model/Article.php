<?php

namespace App\Model;

class Article
{
    private function __construct(
        private int $id,
        private string $title,
        private string $content,
        private string $img,
        private string $author
    ) {}
    public function getId(): int
    {
        return $this->id;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function getContent(): string
    {
        return $this->content;
    }
    public function getImg(): string
    {
        return $this->img;
    }
    public function getAuthor(): string
    {
        return $this->author;
    }
}
