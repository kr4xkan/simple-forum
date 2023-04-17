{ pkgs ? import <nixpkgs> {} }:

pkgs.mkShell {
  name = "it-project";
  nativeBuildInputs = with pkgs; [
    php
    caddy
  ];
}
