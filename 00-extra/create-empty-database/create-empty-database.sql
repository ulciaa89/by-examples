set names utf8;
drop database if exists byexamples;
create database byexamples default character set utf8 collate utf8_polish_ci;
grant all on byexamples.* to redaktor@localhost identified by 'tajnehaslo';
flush privileges;
use byexamples;