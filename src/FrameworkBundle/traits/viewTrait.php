<?php

function render(string $path, $data = []) : void {
    include_once 'views' . $path;
}

function renderComponent(string $path, $data = []) : void {
    render('/Components' . $path, $data);
}

function out(string $text) : void {
    echo htmlspecialchars($text);
  }
  