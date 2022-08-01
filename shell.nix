{ pkgs ? import <nixpkgs> {} }:

with pkgs;

mkShell {
  buildInputs = [
    docker
    docker-compose 
    php
    php81Packages.composer
    jetbrains.phpstorm
  ];
}
