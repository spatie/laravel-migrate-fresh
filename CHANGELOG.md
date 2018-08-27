# Changelog

All notable changes to `laravel-migrate-fresh` will be documented in this file

## 1.5.4 - 2018-08-27
- improve support for Sqlsrv

## 1.5.3 - 2018-02-5
- fixes a bug where `spatial_ref_sys` would not be ignored

## 1.5.2 - 2018-02-06
- ignore `spatial_ref_sys` 

## 1.5.1 - 2017-08-23
- don't drop/create `:memory:` sqlite databases

## 1.5.0 - 2017-07-06

- add command options

## 1.4.5 - 2017-07-05

- improve command description

## 1.4.4 - 2017-05-03

- use fqcn for facade imports

## 1.4.3. - 2017-04-21

- fully qualify the Schema facade to avoid class name conflicts with un-namespaced classes

## 1.4.2 - 2017-04-13

- add support for `used_schemas` parameter in the Postgres configuration

## 1.4.1 - 2017-03-22

- moved table dropper creation code to `TableDropperFactory`

## 1.4.0 - 2017-03-09

- added support for MS SQL Server

## 1.3.1 - 2017-03-04

- fixed bug where dropping of tables in mysql would crash if views were present

## 1.3.0 - 2017-01-11

- added `DroppedTables` and `DroppingTables` events

## 1.2.0 - 2017-01-11

- added support for Sqlite

## 1.1.0 - 2017-01-10

- added support for PostgreSQL

## 1.0.0 - 2017-01-09

- initial release
